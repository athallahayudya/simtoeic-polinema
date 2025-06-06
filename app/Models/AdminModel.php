<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'admin_id';

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
        'current_address'
    ];

    /**
     * Get the user that owns the admin record.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    /**
     * Get the admin's full path KTP scan.
     */
    public function getKtpScanUrlAttribute()
    {
        return asset($this->ktp_scan);
    }

    /**
     * Get the admin's full path photo.
     */
    public function getPhotoUrlAttribute()
    {
        return asset($this->photo);
    }
}
