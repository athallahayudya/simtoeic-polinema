<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResultModel extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_result';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'result_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_id',
        'user_id',
        'score',
        'cerfificate_url'  // Note: keeping the typo from the migration
    ];
    
    /**
     * Get the exam schedule that owns the result.
     */
    public function schedule()
    {
        return $this->belongsTo(ExamScheduleModel::class, 'schedule_id', 'shcedule_id');
    }
    
    /**
     * Get the user that owns the result.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    
    /**
     * Get the certificate URL with asset path.
     */
    public function getCertificateUrlAttribute()
    {
        return asset($this->cerfificate_url);
    }
}