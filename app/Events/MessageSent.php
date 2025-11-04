<?php
// app/Events/MessageSent.php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Kênh broadcast - private channel theo room_id
     */
    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message->room_id);
    }

    /**
     * Tên event
     */
    public function broadcastAs()
    {
        return 'message.sent';
    }

    /**
     * Data gửi đi
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'room_id' => $this->message->room_id,
            'user_id' => $this->message->user_id,
            'message' => $this->message->message,
            'message_type' => $this->message->message_type,
            'is_admin' => $this->message->is_admin,
            'is_read' => $this->message->is_read,
            'created_at' => $this->message->created_at->format('H:i d/m/Y'),
            'user' => [
                'id' => $this->message->user->id,
                'full_name' => $this->message->user->full_name,
                'avatar' => $this->message->user->avatar,
            ]
        ];
    }
}
