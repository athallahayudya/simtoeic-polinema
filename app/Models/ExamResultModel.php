<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResultModel extends Model
{
    use HasFactory;
    
    protected $table = 'exam_result';
    protected $primaryKey = 'result_id';
    protected $fillable = ['schedule_id', 'user_id', 'score', 'cerfificate_url'];
    
    public $timestamps = true;

    // Relationships
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    
    public function schedule()
    {
        return $this->belongsTo(ExamScheduleModel::class, 'schedule_id', 'shcedule_id');
    }
    
    // Get user's NIM through the relationship
    public function getNimAttribute()
    {
        return $this->user ? $this->user->nim : 'N/A';
    }
    
    // Get user's name through the relationship
    public function getNameAttribute()
    {
        return $this->user ? $this->user->name : 'N/A';
    }
    
    // Map the exam ID (could come from schedule)
    public function getIdExamAttribute()
    {
        return $this->schedule ? $this->schedule->exam_code : 'TOE-' . $this->result_id;
    }
    
    // Split total score into listening component (assume 50%)
    public function getListeningScoreAttribute()
    {
        return round($this->score * 0.5);
    }
    
    // Split total score into reading component (assume 50%)
    public function getReadingScoreAttribute()
    {
        return round($this->score * 0.5);
    }
    
    // For total score, use the actual score field
    public function getTotalScoreAttribute()
    {
        return $this->score;
    }
    
    // Get exam date from schedule or created_at
    public function getExamDateAttribute()
    {
        return $this->schedule ? $this->schedule->schedule_date : $this->created_at;
    }
    
    // Determine pass/fail status based on score
    public function getStatusAttribute()
    {
        return $this->score >= 500 ? 'pass' : 'fail';
    }
}