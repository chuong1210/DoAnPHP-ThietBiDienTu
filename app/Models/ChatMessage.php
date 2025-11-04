<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    // QUAN TRỌNG: Không set $table nếu tên table là chat_messages
    // protected $table = 'chat_messages'; // Bỏ dòng này nếu có

    public $timestamps = true;
    const UPDATED_AT = null; // Chỉ dùng created_at

    protected $fillable = [
        'room_id',        // PHẢI LÀ 'room_id' KHÔNG PHẢI 'chat_room_id'
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
        // foreignKey phải là 'room_id'
        return $this->belongsTo(ChatRoom::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
