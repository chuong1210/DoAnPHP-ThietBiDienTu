<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    // QUAN TRỌNG: Không set $table nếu tên table là chat_rooms
    // protected $table = 'chat_rooms'; // Bỏ dòng này nếu có

    protected $fillable = [
        'user_id',
        'admin_id',
        'subject',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        // localKey là 'id' của ChatRoom
        // foreignKey là 'room_id' của ChatMessage
        return $this->hasMany(ChatMessage::class, 'room_id')->orderBy('created_at');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Helper
    public function generateSubject()
    {
        if (!$this->subject) {
            $this->subject = 'Chat hỗ trợ từ ' . $this->user->full_name;
            $this->save();
        }
    }
}
