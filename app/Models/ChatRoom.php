<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'subject',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // open/closed
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    // Scope cho open rooms
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Helper: Tạo subject tự động nếu chưa có
    public function generateSubject()
    {
        if (!$this->subject) {
            $this->subject = 'Chat hỗ trợ từ ' . $this->user->full_name;
            $this->save();
        }
    }
}
