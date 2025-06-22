<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResultModel extends Model
{
    use HasFactory;

    protected $table = 'exam_result';
    protected $primaryKey = 'result_id';
    protected $fillable = [
        'schedule_id',
        'user_id',
        'score',
        'cerfificate_url',
        'exam_id',
        'name',
        'nim',
        'listening_score',
        'reading_score',
        'total_score',
        'exam_date',
        'status',
        'exam_type'
    ];

    public $timestamps = true;

    protected $casts = [
        'exam_date' => 'date',
        'listening_score' => 'integer',
        'reading_score' => 'integer',
        'total_score' => 'integer',
        'score' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function schedule()
    {
        return $this->belongsTo(ExamScheduleModel::class, 'schedule_id', 'schedule_id');
    }

    // Get user's name through the relationship or from stored field
    public function getNameAttribute($value)
    {
        // If name is stored in database, use it
        if ($value) {
            return $value;
        }

        // Otherwise, get from user relationship
        if ($this->user) {
            // Get name based on user role
            if ($this->user->isStudent() && $this->user->student) {
                return $this->user->student->name;
            } elseif ($this->user->isLecturer() && $this->user->lecturer) {
                return $this->user->lecturer->name;
            } elseif ($this->user->isStaff() && $this->user->staff) {
                return $this->user->staff->name;
            } elseif ($this->user->isAlumni() && $this->user->alumni) {
                return $this->user->alumni->name;
            } elseif ($this->user->isAdmin() && $this->user->admin) {
                return $this->user->admin->name;
            }
        }
        return 'N/A';
    }

    // Get user's NIM through the relationship or from stored field
    public function getNimAttribute($value)
    {
        // If NIM is stored in database, use it
        if ($value) {
            return $value;
        }

        // Otherwise, get from user relationship
        if ($this->user && $this->user->isStudent() && $this->user->student) {
            return $this->user->student->nim;
        }
        return $this->user ? $this->user->identity_number : 'N/A';
    }

    // Get exam ID for display (use exam_id if available, otherwise generate from result_id)
    public function getIdExamAttribute()
    {
        return $this->exam_id ?: "TOE-{$this->result_id}";
    }

    // Get listening score (use listening_score if available, otherwise calculate from total)
    public function getListeningScoreAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }
        // If no specific listening score, estimate as 50% of total
        return $this->total_score ? intval($this->total_score * 0.5) : 0;
    }

    // Get reading score (use reading_score if available, otherwise calculate from total)
    public function getReadingScoreAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }
        // If no specific reading score, estimate as 50% of total
        return $this->total_score ? intval($this->total_score * 0.5) : 0;
    }

    // Get total score (use total_score if available, otherwise use legacy score)
    public function getTotalScoreAttribute($value)
    {
        return $value ?: $this->score;
    }

    // Get status based on total score
    public function getStatusAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }
        $totalScore = $this->total_score ?: $this->score;
        return $totalScore >= 500 ? 'pass' : 'fail';
    }

    // Get exam type display name
    public function getExamTypeDisplayAttribute()
    {
        return $this->exam_type === 'gratis' ? 'Unpaid' : 'Paid';
    }

    // Get exam type badge
    public function getExamTypeBadgeAttribute()
    {
        return $this->exam_type === 'gratis'
            ? '<span class="badge badge-success">Unpaid</span>'
            : '<span class="badge badge-primary">Paid</span>';
    }

    // Scopes for exam types
    public function scopeGratis($query)
    {
        return $query->where('exam_type', 'gratis');
    }

    public function scopeMandiri($query)
    {
        return $query->where('exam_type', 'mandiri');
    }
}
