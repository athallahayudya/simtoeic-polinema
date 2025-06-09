<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class TelegramChannel
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTelegram')) {
            return;
        }

        $telegramData = $notification->toTelegram($notifiable);

        if (empty($telegramData['chat_id']) || empty($telegramData['message'])) {
            Log::warning('Telegram notification skipped: missing chat_id or message', [
                'user_id' => $notifiable->user_id ?? null,
                'notification' => get_class($notification)
            ]);
            return;
        }

        $result = null;

        // Check if there's a document to send
        if (!empty($telegramData['document_path'])) {
            // Send document with caption
            $result = $this->telegramService->sendDocument(
                $telegramData['chat_id'],
                $telegramData['document_path'],
                $telegramData['document_caption'] ?? $telegramData['message']
            );

            Log::info('Attempting to send Telegram document', [
                'user_id' => $notifiable->user_id ?? null,
                'chat_id' => $telegramData['chat_id'],
                'document_path' => $telegramData['document_path']
            ]);
        } else {
            // Send regular text message
            $result = $this->telegramService->sendMessage(
                $telegramData['chat_id'],
                $telegramData['message']
            );
        }

        if ($result === null) {
            Log::error('Failed to send Telegram notification', [
                'user_id' => $notifiable->user_id ?? null,
                'chat_id' => $telegramData['chat_id'],
                'notification' => get_class($notification),
                'has_document' => !empty($telegramData['document_path'])
            ]);
        } else {
            Log::info('Telegram notification sent successfully', [
                'user_id' => $notifiable->user_id ?? null,
                'chat_id' => $telegramData['chat_id'],
                'message_id' => $result['result']['message_id'] ?? null,
                'has_document' => !empty($telegramData['document_path'])
            ]);
        }
    }
}
