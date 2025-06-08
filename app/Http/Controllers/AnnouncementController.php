<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function list(Request $request)
    {
        $announcements = AnnouncementModel::select('announcement_id', 'title', 'content', 'announcement_status', 'announcement_date');

        if ($request->announcement_status) {
            $announcements->where('announcement_status', $request->announcement_status);
        }

        return DataTables::of($announcements)
            ->addIndexColumn()
            ->addColumn('announcement_date', function ($announcements) {
                return \Carbon\Carbon::parse($announcements->announcement_date)
                    ->setTimezone('Asia/Jakarta')
                    ->format('d-m-Y');
            })
            ->addColumn('announcement_status', function ($announcements) {
                $badgeClass = $announcements->announcement_status == 'published' ? 'badge-success' : 'badge-secondary';
                return '<span class="badge custom-badge ' . $badgeClass . '">' . ucfirst($announcements->announcement_status) . '</span>';
            })
            ->addColumn('action', function ($announcements) {
                $btn = '<button onclick="modalAction(\'' . url('announcements/' . $announcements->announcement_id . '/show_ajax') . '\')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('announcements/' . $announcements->announcement_id . '/edit') . '\')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('announcements/' . $announcements->announcement_id . '/delete_ajax') . '\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action', 'announcement_status'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $announcements = AnnouncementModel::find($id);
        return view('users-admin.announcement.show', ['announcements' => $announcements]);
    }

    public function confirm_ajax(string $id)
    {
        $announcements = AnnouncementModel::find($id);
        return view('users-admin.announcement.delete', ['announcements' => $announcements]);
    }

    public function destroy(string $id)
    {
        $announcements = AnnouncementModel::find($id);
        if ($announcements) {
            $announcements->delete();

            return response()->json([
                'status' => true,
                'message' => 'Announcements data has been successfully deleted.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function edit(string $id)
    {
        $announcements = AnnouncementModel::find($id);
        return view('users-admin.announcement.edit', ['announcements' => $announcements]);
    }

    public function edit_dashboard(string $id)
    {
        $announcements = AnnouncementModel::find($id);
        return view('users-admin.announcement.edit_dashboard', ['announcements' => $announcements]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'announcement_status' => 'required|in:draft,published',
            'announcement_date' => 'required|date',
            'visible_to' => 'nullable|array',
            'visible_to.*' => 'in:student,staff,alumni,lecturer'
        ]);

        // If no specific roles selected, make visible to all by setting null
        $visibleTo = $request->visible_to && count($request->visible_to) > 0 ? $request->visible_to : null;

        AnnouncementModel::find($id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_status' => $request->announcement_status,
            'announcement_date' => $request->announcement_date,
            'visible_to' => $visibleTo,
        ]);
        return redirect('announcements/')->with('success', 'Announcement updated successfully.');
    }

    public function create()
    {
        return view('users-admin.announcement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'announcement_status' => 'required|in:draft,published',
            'announcement_date' => 'required|date',
            'visible_to' => 'nullable|array',
            'visible_to.*' => 'in:student,staff,alumni,lecturer'
        ]);

        // If no specific roles selected, make visible to all by setting null
        $visibleTo = $request->visible_to && count($request->visible_to) > 0 ? $request->visible_to : null;

        AnnouncementModel::create([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_status' => $request->announcement_status,
            'announcement_date' => $request->announcement_date,
            'visible_to' => $visibleTo,
            'created_by' => auth()->id(),
        ]);

        return redirect('/announcements/')->with('success', 'Announcement created successfully.');
    }

    /**
     * Upload a new announcement PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        Log::info('Upload request received', [
            'title' => $request->title,
            'has_file' => $request->hasFile('announcement_file'),
            'file_size' => $request->hasFile('announcement_file') ? $request->file('announcement_file')->getSize() : 0
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'announcement_file' => 'required|file|mimes:pdf|max:10240',
            'description' => 'nullable|string',
            'visible_to' => 'nullable|array',
            'visible_to.*' => 'in:student,staff,alumni,lecturer'
        ]);

        try {
            // Store the file
            $file = $request->file('announcement_file');
            $fileName = 'announcement_' . time() . '.pdf';
            $filePath = $file->storeAs('public/announcements', $fileName);

            // If no specific roles selected, make visible to all by setting null
            $visibleTo = $request->visible_to && count($request->visible_to) > 0 ? $request->visible_to : null;

            // Create announcement record
            $announcement = new AnnouncementModel();
            $announcement->title = $request->title;
            $announcement->content = $request->description ?? '';
            $announcement->announcement_file = Storage::url($filePath);
            $announcement->announcement_date = now();
            $announcement->announcement_status = 'published';
            $announcement->visible_to = $visibleTo; // Let Laravel handle JSON encoding via model casting
            $announcement->created_by = auth()->id();
            $announcement->save();

            return response()->json([
                'status' => true,
                'message' => 'Announcement uploaded successfully',
                'data' => $announcement
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading announcement: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Error uploading announcement: ' . $e->getMessage()
            ], 500);
        }
    }
}
