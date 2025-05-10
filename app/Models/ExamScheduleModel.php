<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScheduleModel extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_schedule';
    
    /**
     * The primary key for the model.
     * Note: preserving the typo from the migration
     *
     * @var string
     */
    protected $primaryKey = 'shcedule_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_date',
        'exam_time',
        'itc_link',
        'zoom_link'
    ];
}