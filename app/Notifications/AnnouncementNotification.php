<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Services\TelegramService;
use App\Models\AnnouncementModel;
use App\Notifications\TelegramChannel;

class AnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $announcement;

    /**
     * Create a new notification instance.
     *
     * @param AnnouncementModel $announcement
     */
    public function __construct(AnnouncementModel $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];

        // Add telegram channel if user has telegram_chat_id
        if (!empty($notifiable->telegram_chat_id)) {
            $channels[] = TelegramChannel::class;
        }

        return $channels;
    }

    /**
     * Get the telegram representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toTelegram($notifiable)
    {
        $telegramService = new TelegramService();
        $message = $telegramService->formatAnnouncementMessage($this->announcement);

        $data = [
            'chat_id' => $notifiable->telegram_chat_id,
            'message' => $message,
        ];

        // Debug logging
        Log::info('AnnouncementNotification toTelegram', [
            'announcement_id' => $this->announcement->announcement_id,
            'announcement_file' => $this->announcement->announcement_file,
            'has_file' => !empty($this->announcement->announcement_file),
            'chat_id' => $notifiable->telegram_chat_id
        ]);

        // If announcement has PDF file, include it
        if (!empty($this->announcement->announcement_file)) {
            $data['document_path'] = $this->announcement->announcement_file;
            $data['document_caption'] = $message;

            Log::info('Adding document to Telegram notification', [
                'document_path' => $this->announcement->announcement_file,
                'chat_id' => $notifiable->telegram_chat_id
            ]);
        }

        return $data;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'announcement_id' => $this->announcement->announcement_id,
            'title' => $this->announcement->title,
            'content' => $this->announcement->content,
            'announcement_date' => $this->announcement->announcement_date,
        ];
    }
}
