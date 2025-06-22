<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AnnouncementNotification;

class AnnouncementController extends Controller
{
    public function list(Request $request)
    {
        $announcements = AnnouncementModel::select('announcement_id', 'title', 'content', 'announcement_status', 'announcement_date')
            ->orderBy('created_at', 'desc'); // Order by newest first

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

        $announcement = AnnouncementModel::create([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_status' => $request->announcement_status,
            'announcement_date' => $request->announcement_date,
            'visible_to' => $visibleTo,
            'created_by' => auth()->id(),
        ]);

        // Send Telegram notifications if announcement is published
        if ($request->announcement_status === 'published') {
            $this->sendTelegramNotifications($announcement);
        }

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
            'description' => $request->description,
            'announcement_status' => $request->announcement_status,
            'has_announcement_file' => $request->hasFile('announcement_file'),
            'has_photo' => $request->hasFile('photo'),
            'announcement_file_size' => $request->hasFile('announcement_file') ? $request->file('announcement_file')->getSize() : 0,
            'photo_file_size' => $request->hasFile('photo') ? $request->file('photo')->getSize() : 0
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'announcement_file' => 'nullable|file|mimes:pdf|max:20480', // Increased to 20MB
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:20480', // Increased to 20MB
            'description' => 'nullable|string',
            'announcement_status' => 'required|in:draft,published',
            'visible_to' => 'nullable|array',
            'visible_to.*' => 'in:student,staff,alumni,lecturer'
        ], [
            'announcement_file.max' => 'The announcement file may not be greater than 20MB.',
            'photo.max' => 'The photo may not be greater than 20MB.',
            'announcement_file.mimes' => 'The announcement file must be a PDF file.',
            'photo.mimes' => 'The photo must be a JPG, JPEG, or PNG file.'
        ]);

        try {
            // Initialize file columns
            $announcementFileUrl = null;
            $photoUrl = null;

            // Store announcement file if provided
            if ($request->hasFile('announcement_file')) {
                $file = $request->file('announcement_file');
                $fileName = 'announcement_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('public/announcements', $fileName);
                $announcementFileUrl = Storage::url($filePath);
            }

            // Store photo if provided
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = 'photo_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('public/announcements', $fileName);
                $photoUrl = Storage::url($filePath);
            }

            // If no specific roles selected, make visible to all by setting null
            $visibleTo = $request->visible_to && count($request->visible_to) > 0 ? $request->visible_to : null;

            // Create announcement record
            $announcement = new \App\Models\AnnouncementModel();
            $announcement->title = $request->title;
            $announcement->content = $request->description ?? '';
            $announcement->announcement_file = $announcementFileUrl;
            $announcement->photo = $photoUrl;
            $announcement->announcement_date = now();
            $announcement->announcement_status = $request->announcement_status;
            $announcement->visible_to = $visibleTo;
            $announcement->created_by = auth()->id();
            $announcement->save();

            // Send Telegram notifications only if announcement is published
            if ($request->announcement_status === 'published') {
                try {
                    $this->sendTelegramNotifications($announcement);
                } catch (\Exception $telegramError) {
                    Log::error('Telegram notification failed but announcement was saved: ' . $telegramError->getMessage(), [
                        'announcement_id' => $announcement->announcement_id,
                        'trace' => $telegramError->getTraceAsString()
                    ]);
                    // Don't fail the entire upload if Telegram fails
                }
            }

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

    /**
     * Send Telegram notifications to users based on announcement visibility
     *
     * @param AnnouncementModel $announcement
     * @return void
     */
    private function sendTelegramNotifications(AnnouncementModel $announcement)
    {
        try {
            // Check if Telegram bot token is configured
            if (empty(config('services.telegram.bot_token'))) {
                Log::warning('Telegram bot token not configured, skipping notifications');
                return;
            }

            // Get users based on announcement visibility
            $query = UserModel::whereNotNull('telegram_chat_id')
                             ->where('telegram_chat_id', '!=', '');

            // Filter by roles if specific roles are set
            if (!empty($announcement->visible_to)) {
                $query->whereIn('role', $announcement->visible_to);
            }

            $users = $query->get();

            if ($users->count() > 0) {
                // Send notification to each user
                foreach ($users as $user) {
                    try {
                        $user->notify(new AnnouncementNotification($announcement));
                    } catch (\Exception $userError) {
                        Log::error('Failed to send notification to user: ' . $userError->getMessage(), [
                            'user_id' => $user->user_id,
                            'chat_id' => $user->telegram_chat_id,
                            'announcement_id' => $announcement->announcement_id
                        ]);
                        // Continue with other users even if one fails
                    }
                }

                Log::info('Telegram notifications sent for announcement', [
                    'announcement_id' => $announcement->announcement_id,
                    'title' => $announcement->title,
                    'users_count' => $users->count(),
                    'visible_to' => $announcement->visible_to
                ]);
            } else {
                Log::info('No users with Telegram chat_id found for notification', [
                    'announcement_id' => $announcement->announcement_id,
                    'visible_to' => $announcement->visible_to
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending Telegram notifications: ' . $e->getMessage(), [
                'announcement_id' => $announcement->announcement_id,
                'trace' => $e->getTraceAsString()
            ]);
            // Don't throw the exception, just log it
        }
    }
}
