<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Show Telegram settings page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $botInfo = $this->telegramService->getBotInfo();
        $isConnected = $this->telegramService->testConnection();

        return view('users-admin.telegram.index', [
            'type_menu' => 'telegram',
            'bot_info' => $botInfo,
            'is_connected' => $isConnected,
            'bot_token' => config('services.telegram.bot_token')
        ]);
    }

    /**
     * Test Telegram bot connection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function testConnection()
    {
        try {
            $isConnected = $this->telegramService->testConnection();
            $botInfo = null;

            if ($isConnected) {
                $botInfo = $this->telegramService->getBotInfo();
            }

            return response()->json([
                'status' => $isConnected,
                'message' => $isConnected ? 'Bot connection successful!' : 'Bot connection failed!',
                'bot_info' => $botInfo
            ]);
        } catch (\Exception $e) {
            Log::error('Telegram connection test error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update bot token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateToken(Request $request)
    {
        $request->validate([
            'bot_token' => 'required|string'
        ]);

        try {
            // Update the config temporarily for testing
            config(['services.telegram.bot_token' => $request->bot_token]);

            // Test the new token
            $telegramService = new TelegramService();
            $isConnected = $telegramService->testConnection();

            if ($isConnected) {
                // If connection successful, you might want to save to .env file
                // For now, we'll just return success
                return response()->json([
                    'status' => true,
                    'message' => 'Bot token updated and tested successfully!',
                    'bot_info' => $telegramService->getBotInfo()
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid bot token. Connection failed.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating Telegram token: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error updating token: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Send test message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendTestMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string',
            'message' => 'required|string'
        ]);

        try {
            Log::info('Attempting to send test message', [
                'chat_id' => $request->chat_id,
                'message' => $request->message,
                'bot_token_length' => strlen(config('services.telegram.bot_token'))
            ]);

            $result = $this->telegramService->sendMessage(
                $request->chat_id,
                $request->message
            );

            Log::info('Telegram sendMessage result', [
                'result' => $result,
                'chat_id' => $request->chat_id
            ]);

            if ($result) {
                return response()->json([
                    'status' => true,
                    'message' => 'Test message sent successfully!',
                    'telegram_response' => $result
                ]);
            } else {
                Log::warning('Telegram sendMessage returned null', [
                    'chat_id' => $request->chat_id,
                    'message' => $request->message
                ]);

                return response()->json([
                    'status' => false,
                    'message' => 'Failed to send test message. Check chat ID and try again. Check logs for details.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending test message: ' . $e->getMessage(), [
                'chat_id' => $request->chat_id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Error sending message: ' . $e->getMessage()
            ]);
        }
    }
}
