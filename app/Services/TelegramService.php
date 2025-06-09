<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $baseUrl;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->baseUrl = "https://api.telegram.org/bot{$this->botToken}";

        if (empty($this->botToken)) {
            Log::warning('Telegram bot token is not configured');
        }
    }

    /**
     * Send message to a specific chat
     *
     * @param string $chatId
     * @param string $message
     * @param string $parseMode
     * @return array|null
     */
    public function sendMessage($chatId, $message, $parseMode = 'HTML')
    {
        if (empty($this->botToken)) {
            Log::error('Cannot send Telegram message: Bot token not configured');
            return null;
        }

        try {
            Log::info('Attempting to send Telegram message', [
                'chat_id' => $chatId,
                'message_length' => strlen($message),
                'parse_mode' => $parseMode,
                'bot_token_length' => strlen($this->botToken),
                'base_url' => $this->baseUrl
            ]);

            $response = Http::timeout(10)
                ->withOptions(['verify' => config('app.env') === 'production']) // SSL verification based on environment
                ->post("{$this->baseUrl}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => $parseMode,
                ]);

            Log::info('Telegram API Response received', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body(),
                'chat_id' => $chatId
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Telegram API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'chat_id' => $chatId
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Telegram Service Error: ' . $e->getMessage(), [
                'chat_id' => $chatId,
                'message' => $message,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Send message to multiple chats
     *
     * @param array $chatIds
     * @param string $message
     * @param string $parseMode
     * @return array
     */
    public function sendMessageToMultiple($chatIds, $message, $parseMode = 'HTML')
    {
        $results = [];

        foreach ($chatIds as $chatId) {
            if (!empty($chatId)) {
                $result = $this->sendMessage($chatId, $message, $parseMode);
                $results[$chatId] = $result !== null;
            }
        }

        return $results;
    }

    /**
     * Test bot connection
     *
     * @return bool
     */
    public function testConnection()
    {
        if (empty($this->botToken)) {
            Log::error('Cannot test connection: Bot token not configured');
            return false;
        }

        try {
            Log::info('Testing Telegram bot connection', [
                'url' => $this->baseUrl . '/getMe',
                'token_length' => strlen($this->botToken)
            ]);

            $response = Http::timeout(10)
                ->withOptions(['verify' => config('app.env') === 'production']) // SSL verification based on environment
                ->get("{$this->baseUrl}/getMe");

            Log::info('Telegram API Response', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body()
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram Connection Test Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Get bot information
     *
     * @return array|null
     */
    public function getBotInfo()
    {
        try {
            $response = Http::timeout(10)
                ->withOptions(['verify' => config('app.env') === 'production']) // SSL verification based on environment
                ->get("{$this->baseUrl}/getMe");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Failed to get bot info: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send document (PDF) to Telegram
     *
     * @param string $chatId
     * @param string $filePath
     * @param string $caption
     * @return array|null
     */
    public function sendDocument($chatId, $filePath, $caption = '')
    {
        if (empty($this->botToken)) {
            Log::error('Cannot send Telegram document: Bot token not configured');
            return null;
        }

        try {
            Log::info('Attempting to send Telegram document', [
                'chat_id' => $chatId,
                'file_path' => $filePath,
                'caption_length' => strlen($caption),
                'bot_token_length' => strlen($this->botToken)
            ]);

            // Convert storage URL to actual file path
            // $filePath might be like "/storage/announcements/file.pdf"
            $actualPath = str_replace('/storage/', 'storage/', $filePath);
            $fullPath = public_path($actualPath);

            if (!file_exists($fullPath)) {
                Log::error('File not found for Telegram document', [
                    'file_path' => $filePath,
                    'actual_path' => $actualPath,
                    'full_path' => $fullPath
                ]);
                return null;
            }

            $response = Http::timeout(30) // Longer timeout for file upload
                ->withOptions(['verify' => config('app.env') === 'production'])
                ->attach('document', file_get_contents($fullPath), basename($filePath))
                ->post("{$this->baseUrl}/sendDocument", [
                    'chat_id' => $chatId,
                    'caption' => $caption,
                    'parse_mode' => 'HTML',
                ]);

            Log::info('Telegram document API Response received', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body(),
                'chat_id' => $chatId
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Telegram document API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'chat_id' => $chatId,
                'file_path' => $filePath
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Telegram document Service Error: ' . $e->getMessage(), [
                'chat_id' => $chatId,
                'file_path' => $filePath,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Format announcement message for Telegram
     *
     * @param object $announcement
     * @return string
     */
    public function formatAnnouncementMessage($announcement)
    {
        $message = "🔔 <b>Pengumuman Baru</b>\n\n";
        $message .= "<b>Judul:</b> {$announcement->title}\n\n";

        if (!empty($announcement->content)) {
            $message .= "<b>Isi:</b>\n{$announcement->content}\n\n";
        }

        $message .= "<i>Tanggal: " . $announcement->announcement_date->format('d/m/Y') . "</i>\n";
        $message .= "<i>Dari: Admin SIMTOEIC Polinema</i>";

        return $message;
    }
}
