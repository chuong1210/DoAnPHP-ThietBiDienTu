<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    $room = \App\Models\ChatRoom::find($roomId);

    if (!$room) {
        return false;
    }

    // User hoặc admin có thể join
    return $user->id === $room->user_id || $user->isAdmin();
});
