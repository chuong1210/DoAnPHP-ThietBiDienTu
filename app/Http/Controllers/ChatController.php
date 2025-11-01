<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //  1. ADMIN: Xem danh sách phòng chat
    public function listRooms()
    {
        $rooms = ChatRoom::with('user')
            ->orderByDesc('updated_at')
            ->get();


        return view('admin.chat.chat', compact('rooms'));
    }

    //  2. HIỂN THỊ PHÒNG CHAT (cho cả user và admin)
    public function room(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin chọn phòng qua query ?room_id=xx
            $roomId = $request->query('room_id');
            $room = $roomId
                ? ChatRoom::findOrFail($roomId)
                : ChatRoom::with('user')->orderByDesc('updated_at')->first();

            if (!$room) {
                return " Chưa có phòng chat nào.";
            }
        } else {
            // User tự tạo hoặc vào phòng riêng
            $room = ChatRoom::firstOrCreate(
                ['user_id' => $user->id],
                ['subject' => 'Chat hỗ trợ khách hàng', 'status' => 'open']
            );

            // Gán admin nếu chưa có
            if (!$room->admin_id) {
                $admin = User::where('role', 'admin')->first();
                if ($admin) {
                    $room->admin_id = $admin->id;
                    $room->save();
                }
            }
        }

        return view('chat.room', compact('room'));
    }

    //  3. GỬI TIN NHẮN
    public function send(Request $request, $roomId)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $room = ChatRoom::findOrFail($roomId);
        $user = Auth::user();

        $message = ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'is_admin' => $user->role === 'admin',
            'is_read' => false,
        ]);

        $message->load('user');

        //  Gửi event realtime qua Pusher
        event(new MessageSent($message));

        return response()->json([
            'id' => $message->id,
            'message' => $message->message,
            'user' => [
                'id' => $message->user->id,
                'name' => $message->user->full_name,
            ],
            'is_admin' => $message->is_admin,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }

    //  4. LẤY TIN NHẮN CŨ
    public function messages($roomId)
    {
        return ChatMessage::where('room_id', $roomId)
            ->with('user')
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'message' => $m->message,
                'user' => [
                    'id' => $m->user->id,
                    'name' => $m->user->full_name,
                ],
                'is_admin' => $m->is_admin,
                'created_at' => optional($m->created_at)->format('H:i') ?? now()->format('H:i'),
            ]);
    }
}
