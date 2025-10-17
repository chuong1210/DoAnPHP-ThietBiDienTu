<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    public $timestamps = false; // Chỉ dùng created_at

    protected $fillable = [
        'room_id',
        'user_id',
        'message',
        'message_type',
        'is_admin',
        'is_read',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_read' => 'boolean',
    ];

    // Relationships
    public function room()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope cho unread messages
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
