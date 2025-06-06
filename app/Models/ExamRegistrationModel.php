<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRegistrationModel extends Model
{
    use HasFactory;

    // Use the existing exam_result table instead of creating a new one
    protected $table = 'exam_result';
    
    // Primary key from the existing table
    protected $primaryKey = 'result_id';
    
    protected $fillable = [
        'user_id',
        'schedule_id',
        'score',         // Can be NULL for initial registration
        'cerfificate_url',  // Fixed syntax error here (was using => incorrectly)
        'registration_date' // We'll use created_at for this
    ];
    
    // Set default values for fields that can't be NULL
    protected $attributes = [
        'cerfificate_url' => ''  // Default empty string for this field
    ];
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    
    public function schedule()
    {
        // Fix the column name to match your migration (shcedule_id)
        return $this->belongsTo(ExamScheduleModel::class, 'schedule_id', 'schedule_id');
    }
}
