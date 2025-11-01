<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatRoom;

Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    return ChatRoom::where('id', $roomId)
        ->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('admin_id', $user->id);
        })->exists();
});
