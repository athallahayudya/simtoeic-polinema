<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniModel extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumni';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'alumni_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'ktp_scan',
        'photo',
        'home_address',
        'current_address'
    ];
    
    /**
     * Get the user that owns the alumni record.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}