<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lecturer';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'lecturer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'nidn',
        'ktp_scan',
        'photo',
        'home_address',
        'current_address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the lecturer.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the lecturer's full path KTP scan.
     */
    public function getKtpScanUrlAttribute()
    {
        return asset($this->ktp_scan);
    }

    /**
     * Get the lecturer's full path photo.
     */
    public function getPhotoUrlAttribute()
    {
        return asset($this->photo);
    }
}