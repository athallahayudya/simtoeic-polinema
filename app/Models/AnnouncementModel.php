<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    use HasFactory;
    
    protected $table = 'announcement';
    protected $primaryKey = 'announcement_id';
    
    protected $fillable = [
        'title',
        'content',
        'announcement_file',
        'photo',
        'announcement_status',
        'announcement_date',
        'visible_to',
        'created_by'
    ];
    
    protected $casts = [
        'announcement_date' => 'date',
        'visible_to' => 'array'
    ];
    
    // Check if announcement is visible to a specific role
    public function isVisibleTo($role)
    {
        if (empty($this->visible_to)) {
            return true; // If not specified, visible to all
        }
        
        return in_array($role, is_array($this->visible_to) ? $this->visible_to : []);
    }
    
    // Get the user who created this announcement
    public function creator()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'user_id');
    }
}
