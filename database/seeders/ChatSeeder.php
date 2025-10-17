<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run()
    {
        // Giả sử user_id=2 là user thường, admin_id=1 là admin
        $room = ChatRoom::create([
            'user_id' => 2, // Từ sample users
            'admin_id' => 1, // Admin
            'subject' => 'Hỏi về sản phẩm iPhone',
            'status' => 'open',
        ]);

        ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => 2,
            'message' => 'Xin chào, iPhone 15 có màu gì?',
            'message_type' => 'text',
            'is_admin' => false,
        ]);

        ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => 1, // Admin
            'message' => 'Chào bạn! iPhone 15 có các màu: Đen, Trắng, Xanh, Hồng.',
            'message_type' => 'text',
            'is_admin' => true,
        ]);
    }
}
