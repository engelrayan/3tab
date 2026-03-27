<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atab_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('atab_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // nullable لو الحساب اتحذف
            $table->foreignId('sender_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->text('body');

            // هل القراءة تمت؟
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atab_messages');
    }
};
