<?php

namespace App\Imports;

use App\Models\ExamResultModel;
use App\Models\UserModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;
use Throwable;

class ExamResultsImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Debug what we're getting from Excel
        Log::info('Excel row data:', $row);
        
        // Skip rows without IDs
        if (empty($row['id'])) {
            return null;
        }
        
        // Get student NIM from Excel
        $nim = $row['id'];
        
        // Find the associated user, if not found, skip
        $user = UserModel::where('nim', $nim)->first();
        if (!$user) {
            Log::warning("User with NIM {$nim} not found.");
            return null;
        }
        
        // Extract scores from Excel
        $listeningScore = isset($row['l']) ? (int)$row['l'] : 0;
        $readingScore = isset($row['r']) ? (int)$row['r'] : 0;
        $totalScore = isset($row['tot']) ? (int)$row['tot'] : ($listeningScore + $readingScore);
        
        // Get or create a default schedule ID
        $scheduleId = 1; // Default schedule ID
        
        // Certificate URL (optional, could be generated later)
        $certificateUrl = '';
        
        // Create or update result
        return new ExamResultModel([
            'user_id' => $user->user_id,
            'schedule_id' => $scheduleId,
            'score' => $totalScore,
            'cerfificate_url' => $certificateUrl
        ]);
    }
    
    /**
     * @param \Throwable $e
     */
    public function onError(Throwable $e)
    {
        Log::error('Excel import error: ' . $e->getMessage());
        return null;
    }
    
    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }
}