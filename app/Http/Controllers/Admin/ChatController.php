<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Danh sách các room chat (Admin)
     */
    // app/Http/Controllers/Admin/ChatController.php
    public function index()
    {
        $rooms = ChatRoom::with(['user'])
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('is_read', false)->where('is_admin', false);
            }])
            ->orderByDesc('updated_at')
            ->get();

        // Thêm last_message và format trực tiếp trên model
        $rooms->each(function ($room) {
            $lastMessage = $room->messages()->latest()->first();

            $room->last_message = $lastMessage ? [
                'message' => $lastMessage->message,
                'created_at' => $lastMessage->created_at->diffForHumans(),
                'is_admin' => $lastMessage->is_admin,
            ] : null;

            $room->updated_at_formatted = $room->updated_at->diffForHumans();
        });

        return view('admin.chat.index', compact('rooms'));
    }

    /**
     * Get messages for a specific room (AJAX)
     */
    public function getMessages(ChatRoom $room)
    {
        $messages = $room->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_admin' => $msg->is_admin,
                    'is_read' => $msg->is_read,
                    'created_at' => $msg->created_at->format('H:i d/m'),
                    'user' => [
                        'id' => $msg->user->id,
                        'full_name' => $msg->user->full_name,
                        'avatar' => $msg->user->avatar,
                    ]
                ];
            });

        // Mark as read
        $room->messages()
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $messages,
            'room' => [
                'id' => $room->id,
                'user' => $room->user,
                'status' => $room->status,
            ]
        ]);
    }

    /**
     * Admin gửi tin nhắn
     */
    public function sendMessage(Request $request, ChatRoom $room)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'text',
            'is_admin' => true,
            'is_read' => false,
        ]);

        $message->load('user');

        // Update room
        $room->update([
            'admin_id' => Auth::id(),
        ]);
        $room->touch();

        // Broadcast real-time
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => $message->is_admin,
                'created_at' => $message->created_at->format('H:i d/m'),
                'user' => [
                    'id' => $message->user->id,
                    'full_name' => $message->user->full_name,
                    'avatar' => $message->user->avatar,
                ]
            ]
        ]);
    }

    /**
     * Đóng room chat
     */
    public function closeRoom(ChatRoom $room)
    {
        $room->update(['status' => 'closed']);

        return response()->json(['success' => true]);
    }

    /**
     * Mở lại room chat
     */
    public function openRoom(ChatRoom $room)
    {
        $room->update(['status' => 'open']);

        return response()->json(['success' => true]);
    }
}
