<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable; //implement auth
use App\Models\StudentModel;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'identity_number',
        'password',
        'exam_status',
        'phone_number',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Hide the password when serializing the model
    ];

    protected $casts = [];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isAlumni()
    {
        return $this->role === 'alumni';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // mutator to hash password
    public function setPasswordAttribute($value)
    {
        if ($value) {
            // Only hash if it's not already hashed
            if (strlen($value) < 60 || !preg_match('/^\$2[ayb]\$.{56}$/', $value)) {
                $this->attributes['password'] = bcrypt($value);
            } else {
                $this->attributes['password'] = $value; // Already hashed, store as is
            }
        }
    }

    
    public function student()
    {
        return $this->hasOne(StudentModel::class, 'user_id', 'user_id');
    }
     public function staff()
    {
        return $this->hasOne(StaffModel::class, 'user_id', 'user_id');
    }
     public function lecturer()
    {
        return $this->hasOne(LecturerModel::class, 'user_id', 'user_id');
    }
     public function Alumni()
    {
        return $this->hasOne(AlumniModel::class, 'user_id', 'user_id');
    }
}

