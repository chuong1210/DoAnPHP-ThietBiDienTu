<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function room()
    {
        $user = Auth::user();

        // Nếu là admin → mở phòng theo user_id được truyền vào URL
        // Nếu là user → mở phòng của chính mình
        $room = ChatRoom::firstOrCreate(
            [
                'user_id'  => $user->isAdmin() ? request('user_id', $user->id) : $user->id,
                'admin_id' => $user->isAdmin() ? $user->id : null,
            ],
            [
                'subject' => 'Hỗ trợ khách hàng',
                'status'  => 'open',
            ]
        );

        // Nếu user chưa có admin thì gán admin mặc định
        if (!$user->isAdmin() && !$room->admin_id) {
            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin) {
                $room->admin_id = $admin->id;
                $room->save();
            }
        }

        // Gửi view kèm dữ liệu phòng
        return view('chat.room', compact('room'));
    }

    /**
     *  Gửi tin nhắn
     */
    public function send(Request $request, $roomId)
    {
        $room = ChatRoom::findOrFail($roomId);
        $user = auth()->user();

        $message = $room->messages()->create([
            'user_id' => $user->id,
            'message' => $request->message,
            'is_admin' => $user->role === 'admin',
            'is_read' => false,
        ]);

        //  Phát event realtime
        event(new MessageSent($message));

        return response()->json([
            'id' => $message->id,
            'message' => $message->message,
            'user' => [
                'id' => $user->id,
                'name' => $user->name ?? $user->full_name,
            ],
            'is_admin' => $message->is_admin,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }


    /**
     *  Lấy tin nhắn cũ trong phòng
     */
    public function messages($roomId)
    {
        return ChatMessage::where('room_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->take(50)
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'user'       => [
                    'id'   => $m->user->id,
                    'name' => $m->user->full_name,
                ],
                'is_admin'   => $m->is_admin,
                'created_at' => $m->created_at?->format('H:i'),
            ]);
    }


    public function listRooms()
    {
        $this->authorize('admin');

        $rooms = ChatRoom::with(['user', 'messages'])
            ->orderByDesc('updated_at')
            ->get();

        return view('chat.admin_list', compact('rooms'));
    }
}
