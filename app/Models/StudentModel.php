<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'student_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'nim',
        'major',
        'study_program',
        'campus',
        'photo',
        'ktp_scan',
        'ktm_scan',
        'home_address',
        'current_address'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'campus' => 'string',
    ];

    /**
     * Campus location options.
     *
     * @var array
     */
    public static $campusOptions = [
        'malang' => 'Malang',
        'psdku_kediri' => 'PSDKU Kediri',
        'psdku_lumajang' => 'PSDKU Lumajang',
        'psdku_pamekasan' => 'PSDKU Pamekasan',
    ];

    /**
     * Get the user that owns the student.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    /**
     * Get the full campus name.
     *
     * @return string
     */
    public function getCampusNameAttribute()
    {
        return self::$campusOptions[$this->campus] ?? $this->campus;
    }

    /**
     * Get the student's full path KTP scan.
     */
    public function getKtpScanUrlAttribute()
    {
        return asset($this->ktp_scan);
    }

    /**
     * Get the student's full path KTM scan.
     */
    public function getKtmScanUrlAttribute()
    {
        return asset($this->ktm_scan);
    }

    /**
     * Get the student's full path photo.
     */
    public function getPhotoUrlAttribute()
    {
        return asset($this->photo);
    }
}
