<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequestModel;
use App\Models\UserModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                $files = [];

                // Handle first file
                if ($request->certificate_file) {
                    $fileUrl = asset('storage/' . $request->certificate_file);
                    $fileName = basename($request->certificate_file);
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        $files[] = '<a href="' . $fileUrl . '" target="_blank" class="btn btn-sm btn-info mr-1 mb-1">
                                    <i class="fas fa-image"></i> File 1
                                </a>';
                    } else {
                        $files[] = '<a href="' . $fileUrl . '" target="_blank" class="btn btn-sm btn-primary mr-1 mb-1">
                                    <i class="fas fa-file-pdf"></i> File 1
                                </a>';
                    }
                }

                // Handle second file
                if ($request->certificate_file_2) {
                    $fileUrl2 = asset('storage/' . $request->certificate_file_2);
                    $fileName2 = basename($request->certificate_file_2);
                    $fileExtension2 = strtolower(pathinfo($fileName2, PATHINFO_EXTENSION));

                    if (in_array($fileExtension2, ['jpg', 'jpeg', 'png'])) {
                        $files[] = '<a href="' . $fileUrl2 . '" target="_blank" class="btn btn-sm btn-info mr-1 mb-1">
                                    <i class="fas fa-image"></i> File 2
                                </a>';
                    } else {
                        $files[] = '<a href="' . $fileUrl2 . '" target="_blank" class="btn btn-sm btn-primary mr-1 mb-1">
                                    <i class="fas fa-file-pdf"></i> File 2
                                </a>';
                    }
                }

                return !empty($files) ? implode('<br>', $files) : '<span class="text-muted">No files</span>';
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
        try {
            $request = VerificationRequestModel::with(['user.student', 'approvedBy'])
                ->findOrFail($id);

            // Check if user exists
            if (!$request->user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User information not found for this request.'
                ], 404);
            }

            // Get student information safely
            $student = $request->user->student ?? null;
            $studentName = $student ? $student->name : 'N/A';
            $studentNim = $student ? $student->nim : 'N/A';

            // Get approved by information safely
            $approvedByName = $request->approvedBy ? $request->approvedBy->name : null;

            return response()->json([
                'success' => true,
                'data' => [
                    'request_id' => $request->request_id,
                    'student_name' => $studentName,
                    'student_nim' => $studentNim,
                    'comment' => $request->comment,
                    'certificate_file' => $request->certificate_file,
                    'certificate_file_2' => $request->certificate_file_2,
                    'status' => $request->status,
                    'admin_notes' => $request->admin_notes,
                    'approved_by' => $approvedByName,
                    'created_at' => $request->formatted_created_at,
                    'approved_at' => $request->formatted_approved_at
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving verification request details: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the request details.'
            ], 500);
        }
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
            Log::info('Starting PDF generation for request ID: ' . $id);
            $pdfPath = $this->generateCertificate($verificationRequest);

            if (!$pdfPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate verification letter. Please try again.'
                ]);
            }

            Log::info('PDF generated successfully: ' . $pdfPath);

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
            Log::error('Error approving verification request: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

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
        try {
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

            // Check if user exists
            if (!$verificationRequest->user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User information not found for this request.'
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
                'message' => 'Request has been rejected successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error rejecting verification request: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download generated certificate
     */
    public function downloadCertificate($id)
    {
        try {
            $verificationRequest = VerificationRequestModel::findOrFail($id);

            if ($verificationRequest->status !== 'approved' || !$verificationRequest->generated_certificate_path) {
                abort(404, 'Certificate not found or not approved yet.');
            }

            $filePath = storage_path('app/public/' . $verificationRequest->generated_certificate_path);

            if (!file_exists($filePath)) {
                Log::error('Certificate file not found at path: ' . $filePath);
                abort(404, 'Certificate file not found.');
            }

            // Check if user and student relationship exists
            if (!$verificationRequest->user || !$verificationRequest->user->student) {
                Log::error('User or student relationship missing for request ID: ' . $id);
                abort(404, 'Student information not found for this certificate.');
            }

            $student = $verificationRequest->user->student;
            $fileName = 'Verification_Letter_' . ($student->nim ?? 'Unknown') . '_' . date('Y-m-d') . '.pdf';

            Log::info('Downloading certificate for student: ' . $student->name . ' (Request ID: ' . $id . ')');

            return response()->download($filePath, $fileName);
        } catch (\Exception $e) {
            Log::error('Error downloading certificate: ' . $e->getMessage());
            abort(500, 'An error occurred while downloading the certificate.');
        }
    }
    /**
     * Generate PDF certificate using blank template (no positioning/filling)
     */
    private function generateCertificate($verificationRequest)
    {
        // Verify user and student relationship exists
        if (!$verificationRequest->user || !$verificationRequest->user->student) {
            Log::error('Unable to generate certificate: User or student relationship missing for request ID: ' . $verificationRequest->request_id);
            throw new \Exception('Student information not found');
        }

        $student = $verificationRequest->user->student;
        Log::info('Generating blank certificate template for student: ' . $student->name);

        try {
            // Simply copy the blank template to the storage location
            $templatePath = public_path('surat-keterangan-ujian.pdf');
            Log::info('Template path: ' . $templatePath);

            if (!file_exists($templatePath)) {
                throw new \Exception('Template PDF not found at: ' . $templatePath);
            }

            Log::info('Template file exists, copying blank template...');

            // Save the blank template as the certificate
            $fileName = 'verification_' . $verificationRequest->request_id . '_' . time() . '.pdf';
            $filePath = 'verification_letters/' . $fileName;
            $fullPath = storage_path('app/public/' . $filePath);

            // Ensure directory exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Copy the blank template
            copy($templatePath, $fullPath);

            Log::info('Blank certificate template generated successfully');
            return $filePath;
        } catch (\Exception $e) {
            Log::error('Template copy failed: ' . $e->getMessage());
            Log::info('Falling back to simple PDF generation');

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
            // Verify user and student relationship exists
            if (!$verificationRequest->user || !$verificationRequest->user->student) {
                Log::error('Unable to generate simple certificate: User or student relationship missing for request ID: ' . $verificationRequest->request_id);
                return null;
            }

            $student = $verificationRequest->user->student;

            // Prepare data for PDF
            $data = [
                'student_name' => $student->name ?? 'N/A',
                'student_nim' => $student->nim ?? 'N/A',
                'student_major' => $student->major ?? 'N/A',
                'student_study_program' => $student->study_program ?? 'N/A',
                'request_date' => $verificationRequest->created_at->format('d F Y'),
                'approval_date' => now()->format('d F Y'),
                'admin_name' => Auth::user()->name ?? 'Admin',
                'barcode_data' => 'VERIFY-' . $verificationRequest->request_id . '-' . time()
            ];

            // Check if the verification letter view exists
            if (!view()->exists('pdf.verification-letter')) {
                Log::error('PDF template view "pdf.verification-letter" not found');
                return null;
            }

            // Generate PDF using the template
            $pdf = PDF::loadView('pdf.verification-letter', $data);

            // Save PDF
            $fileName = 'verification_' . $verificationRequest->request_id . '_' . time() . '.pdf';
            $filePath = 'verification_letters/' . $fileName;

            // Ensure directory exists
            $storagePath = storage_path('app/public/verification_letters');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            Storage::disk('public')->put($filePath, $pdf->output());

            // Verify the file was saved successfully
            if (!Storage::disk('public')->exists($filePath)) {
                Log::error('Failed to save PDF file to storage');
                return null;
            }

            return $filePath;
        } catch (\Exception $e) {
            Log::error('Fallback PDF generation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }
}
