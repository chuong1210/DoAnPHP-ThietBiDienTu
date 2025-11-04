<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('chat_messages', function (Blueprint $table) {
            // Nếu cột message_type chưa có 'file' thì sửa lại ENUM
            $table->enum('message_type', ['text', 'image', 'file'])
                ->default('text')
                ->change();

            // Nếu bạn muốn thêm index mới:
            $table->index(['room_id', 'created_at']);
            $table->index(['is_read', 'is_admin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('chat_messages', function (Blueprint $table) {
            // Quay lại enum cũ (không có 'file')
            $table->enum('message_type', ['text', 'image'])
                ->default('text')
                ->change();

            // Xóa index mới
            $table->dropIndex(['room_id', 'created_at']);
            $table->dropIndex(['is_read', 'is_admin']);
        });
    }
};
