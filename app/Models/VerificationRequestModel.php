<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequestModel extends Model
{
    use HasFactory;

    protected $table = 'verification_requests';
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'user_id',
        'comment',
        'certificate_file',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
        'generated_certificate_path'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(UserModel::class, 'approved_by', 'user_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Pending</span>';
            case 'approved':
                return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i>Approved</span>';
            case 'rejected':
                return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Rejected</span>';
            default:
                return '<span class="badge badge-secondary"><i class="fas fa-question mr-1"></i>Unknown</span>';
        }
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getFormattedApprovedAtAttribute()
    {
        return $this->approved_at ? $this->approved_at->format('d M Y H:i') : '-';
    }
}
