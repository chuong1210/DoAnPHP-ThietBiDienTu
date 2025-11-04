<?php
// app/Http/Controllers/Client/ChatController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Get or create chat room (for widget)
     */
    public function getRoom()
    {
        $user = Auth::user();

        // Tìm hoặc tạo room chat của user
        $room = ChatRoom::firstOrCreate(
            ['user_id' => $user->id],
            [
                'subject' => 'Chat từ ' . $user->full_name,
                'status' => 'open'
            ]
        );

        // Load messages
        $messages = $room->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_admin' => $msg->is_admin,
                    'created_at' => $msg->created_at->format('H:i'),
                    'user' => [
                        'full_name' => $msg->user->full_name
                    ]
                ];
            });

        return response()->json([
            'room' => $room,
            'messages' => $messages
        ]);
    }

    /**
     * Get unread count
     */
    public function unreadCount()
    {
        $user = Auth::user();

        $count = ChatMessage::whereHas('room', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->where('is_admin', true)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Send message
     */
    public function sendMessage(Request $request, ChatRoom $room)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Kiểm tra quyền
        if ($room->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'text',
            'is_admin' => false,
            'is_read' => false,
        ]);

        $message->load('user');

        // Update room timestamp
        $room->touch();

        // Broadcast real-time
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => $message->is_admin,
                'created_at' => $message->created_at->format('H:i'),
                'user' => [
                    'full_name' => $message->user->full_name
                ]
            ]
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(ChatRoom $room)
    {
        if ($room->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $room->messages()
            ->where('is_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
