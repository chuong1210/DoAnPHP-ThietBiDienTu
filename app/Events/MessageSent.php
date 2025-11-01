<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {

        return new PrivateChannel('chat.room.' . $this->message->room_id);
    }

    public function broadcastWith()
    {
        return [
            'id'         => $this->message->id,
            'message'    => $this->message->message,
            'user'       => [
                'id'   => $this->message->user->id,
                'name' => $this->message->user->full_name,
            ],
            'is_admin'   => $this->message->is_admin,
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }
}
