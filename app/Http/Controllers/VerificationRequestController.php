<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequestModel;
use App\Models\UserModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class VerificationRequestController extends Controller
{
    /**
     * Display verification requests for admin
     */
    public function index()
    {
        $type_menu = 'verification_requests';

        return view('users-admin.verification-requests.index', compact('type_menu'));
    }

    /**
     * Get verification requests data for DataTables
     */
    public function getData()
    {
        $requests = VerificationRequestModel::with(['user.student'])
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($requests)
            ->addIndexColumn()
            ->addColumn('name', function ($request) {
                $user = $request->user;
                $student = $user->student ?? null;

                if ($student) {
                    return '<strong>' . $student->name . '</strong>';
                }
                return '<span class="text-muted">Data not available</span>';
            })
            ->addColumn('role', function ($request) {
                $user = $request->user;
                return '<span class="badge badge-primary">' . ucfirst($user->role) . '</span>';
            })
            ->addColumn('description', function ($request) {
                $comment = $request->comment;
                if (strlen($comment) > 100) {
                    return '<span title="' . htmlspecialchars($comment) . '">' .
                        substr($comment, 0, 100) . '...</span>';
                }
                return $comment;
            })
            ->addColumn('supporting_evidence', function ($request) {
                if ($request->certificate_file) {
                    $fileUrl = asset('storage/' . $request->certificate_file);
                    $fileName = basename($request->certificate_file);
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        return '<a href="' . $fileUrl . '" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-image"></i> View Image
                                </a>';
                    } else {
                        return '<a href="' . $fileUrl . '" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-pdf"></i> View PDF
                                </a>';
                    }
                }
                return '<span class="text-muted">No file</span>';
            })
            ->addColumn('status_badge', function ($request) {
                return $request->status_badge;
            })
            ->addColumn('actions', function ($request) {
                $actions = '<div class="btn-group" role="group">';

                // View button
                $actions .= '<button type="button" class="btn btn-info btn-sm" onclick="viewRequest(' . $request->request_id . ')" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>';

                if ($request->status === 'pending') {
                    // Approve button
                    $actions .= '<button type="button" class="btn btn-success btn-sm ml-1" onclick="approveRequest(' . $request->request_id . ')" title="Approve">
                        <i class="fas fa-check"></i>
                    </button>';

                    // Reject button
                    $actions .= '<button type="button" class="btn btn-danger btn-sm ml-1" onclick="rejectRequest(' . $request->request_id . ')" title="Reject">
                        <i class="fas fa-times"></i>
                    </button>';
                }



                $actions .= '</div>';
                return $actions;
            })
            ->addColumn('formatted_date', function ($request) {
                return $request->formatted_created_at;
            })
            ->rawColumns(['name', 'role', 'description', 'supporting_evidence', 'status_badge', 'actions'])
            ->make(true);
    }

    /**
     * Get request details for modal
     */
    public function show($id)
    {
        $request = VerificationRequestModel::with(['user.student', 'approvedBy'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'request_id' => $request->request_id,
                'student_name' => $request->user->student->name ?? 'N/A',
                'student_nim' => $request->user->student->nim ?? 'N/A',
                'comment' => $request->comment,
                'certificate_file' => $request->certificate_file,
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'approved_by' => $request->approvedBy->name ?? null,
                'created_at' => $request->formatted_created_at,
                'approved_at' => $request->formatted_approved_at
            ]
        ]);
    }

    /**
     * Approve certificate request
     */
    public function approve(Request $request, $id)
    {
        try {
            $request->validate([
                'admin_notes' => 'nullable|string|max:500'
            ]);

            $verificationRequest = VerificationRequestModel::findOrFail($id);

            if ($verificationRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Request has already been processed.'
                ]);
            }

            // Check if student relationship exists
            if (!$verificationRequest->user || !$verificationRequest->user->student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student information not found. Cannot generate verification letter.'
                ]);
            }

            // Generate PDF certificate
            \Log::info('Starting PDF generation for request ID: ' . $id);
            $pdfPath = $this->generateCertificate($verificationRequest);

            if (!$pdfPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate verification letter. Please try again.'
                ]);
            }

            \Log::info('PDF generated successfully: ' . $pdfPath);

            $verificationRequest->update([
                'status' => 'approved',
                'admin_notes' => $request->admin_notes,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'generated_certificate_path' => $pdfPath
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Request has been approved and verification letter has been generated.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error approving verification request: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject certificate request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);

        $verificationRequest = VerificationRequestModel::findOrFail($id);

        if ($verificationRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Request has already been processed.'
            ]);
        }

        $verificationRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request has been rejected.'
        ]);
    }

    /**
     * Download generated certificate
     */
    public function downloadCertificate($id)
    {
        $verificationRequest = VerificationRequestModel::findOrFail($id);

        if ($verificationRequest->status !== 'approved' || !$verificationRequest->generated_certificate_path) {
            abort(404, 'Certificate not found or not approved yet.');
        }

        $filePath = storage_path('app/public/' . $verificationRequest->generated_certificate_path);

        if (!file_exists($filePath)) {
            abort(404, 'Certificate file not found.');
        }

        $student = $verificationRequest->user->student;
        $fileName = 'Verification_Letter_' . ($student->nim ?? 'Unknown') . '.pdf';

        return response()->download($filePath, $fileName);
    }

    /**
     * Generate PDF certificate using existing template
     */
    private function generateCertificate($verificationRequest)
    {
        $student = $verificationRequest->user->student;
        \Log::info('Generating certificate for student: ' . $student->name);

        try {
            // Create new PDF instance
            \Log::info('Creating FPDI instance');
            $pdf = new Fpdi();
            $pdf->AddPage();

            // Import the existing PDF template
            $templatePath = public_path('surat-keterangan-ujian.pdf');
            \Log::info('Template path: ' . $templatePath);

            if (!file_exists($templatePath)) {
                throw new \Exception('Template PDF not found at: ' . $templatePath);
            }

            \Log::info('Template file exists, importing...');

            $pageCount = $pdf->setSourceFile($templatePath);
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0, 210); // A4 width = 210mm

            // Set font for text overlay (use helvetica which is built-in)
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetTextColor(0, 0, 0);

            // Fill in the form fields with exact coordinates based on template
            $pdf->SetFont('helvetica', '', 9);
            $pdf->SetTextColor(0, 0, 0);

            // Coordinates based on careful analysis of the template:

            // Header name field (Yang bertanda tangan di bawah ini)
            $pdf->SetXY(50, 80);
            $pdf->Cell(0, 4, $student->name ?? 'N/A', 0, 0, 'L');

            // Field 1: Nama
            $pdf->SetXY(50, 95);
            $pdf->Cell(0, 4, $student->name ?? 'N/A', 0, 0, 'L');

            // Field 2: NIP (use as NIM)
            $pdf->SetXY(50, 102);
            $pdf->Cell(0, 4, $student->nim ?? 'N/A', 0, 0, 'L');

            // Field 3: Pangkat, golongan, ruang (use as study program)
            $pdf->SetXY(120, 109);
            $pdf->Cell(0, 4, $student->study_program ?? 'N/A', 0, 0, 'L');

            // Field 4: Jabatan (use as major)
            $pdf->SetXY(70, 116);
            $pdf->Cell(0, 4, $student->major ?? 'N/A', 0, 0, 'L');

            // Add approval date in the signature area (bottom right)
            $pdf->SetXY(140, 200);
            $pdf->Cell(0, 5, 'Malang, ' . now()->format('d F Y'), 0, 0, 'L');

            // Add admin name in signature area (bottom right)
            $pdf->SetXY(140, 240);
            $pdf->Cell(0, 5, Auth::user()->name, 0, 0, 'L');

            // Generate QR Code
            $qrData = 'VERIFY-' . $verificationRequest->request_id . '-' . time();
            $qrCode = new QrCode($qrData);
            $qrCode->setSize(60);
            $writer = new PngWriter();
            $qrResult = $writer->write($qrCode);

            // Save QR code temporarily
            $qrTempPath = storage_path('app/temp_qr_' . time() . '.png');
            file_put_contents($qrTempPath, $qrResult->getString());

            // Add QR code to PDF (adjust position as needed)
            $pdf->Image($qrTempPath, 160, 250, 20, 20); // Adjust position and size

            // Clean up temporary QR file
            if (file_exists($qrTempPath)) {
                unlink($qrTempPath);
            }

            // Save the final PDF
            $fileName = 'verification_' . $verificationRequest->request_id . '_' . time() . '.pdf';
            $filePath = 'verification_letters/' . $fileName;
            $fullPath = storage_path('app/public/' . $filePath);

            // Ensure directory exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $pdf->Output($fullPath, 'F');

            return $filePath;
        } catch (\Exception $e) {
            // Log error and fallback to simple PDF generation
            \Log::error('FPDI PDF generation failed: ' . $e->getMessage());
            \Log::info('Falling back to simple PDF generation');

            // Fallback: create simple PDF without template
            return $this->generateSimpleCertificate($verificationRequest);
        }
    }

    /**
     * Fallback method to generate simple certificate
     */
    private function generateSimpleCertificate($verificationRequest)
    {
        try {
            $student = $verificationRequest->user->student;

            // Prepare data for PDF
            $data = [
                'student_name' => $student->name ?? 'N/A',
                'student_nim' => $student->nim ?? 'N/A',
                'student_major' => $student->major ?? 'N/A',
                'student_study_program' => $student->study_program ?? 'N/A',
                'request_date' => $verificationRequest->created_at->format('d F Y'),
                'approval_date' => now()->format('d F Y'),
                'admin_name' => Auth::user()->name,
                'barcode_data' => 'VERIFY-' . $verificationRequest->request_id . '-' . time()
            ];

            // Generate PDF using the template
            $pdf = PDF::loadView('pdf.verification-letter', $data);

            // Save PDF
            $fileName = 'verification_' . $verificationRequest->request_id . '_' . time() . '.pdf';
            $filePath = 'verification_letters/' . $fileName;

            // Ensure directory exists
            $fullPath = storage_path('app/public/' . dirname($filePath));
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            Storage::disk('public')->put($filePath, $pdf->output());

            return $filePath;
        } catch (\Exception $e) {
            \Log::error('Fallback PDF generation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }
}
