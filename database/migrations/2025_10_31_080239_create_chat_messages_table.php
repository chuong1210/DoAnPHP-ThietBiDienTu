<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->enum('message_type', ['text', 'image'])->default('text');
            $table->boolean('is_admin')->default(false)->comment('TRUE nếu từ admin');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('room_id')->references('id')->on('chat_rooms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // INDEX
            $table->index('room_id', 'idx_room');
            $table->index('user_id', 'idx_user');
            $table->index('is_read', 'idx_is_read');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
