<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable()->comment('ID admin tham gia chat');
            $table->string('subject', 255)->nullable()->comment('Tiêu đề chat (tự động tạo)');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');

            // INDEX
            $table->index('user_id', 'idx_user');
            $table->index('admin_id', 'idx_admin');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};
