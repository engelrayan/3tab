<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atabs', function (Blueprint $table) {
            $table->id();

            // المُرسِل — nullable لأن الحساب ممكن يتحذف
            $table->foreignId('sender_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // المُستقبِل
            $table->foreignId('receiver_id')
            ->nullable()
            ->constrained('users')
           ->nullOnDelete();
            // هل الإرسال مجهول؟
            $table->boolean('is_anonymous')->default(false);

            // حالة العتاب
            $table->enum('status', [
                'pending',      // أُرسل، لم يُفتح بعد
                'active',       // محادثة جارية
                'reconciled',   // تمت المصالحة
                'closed',       // أُغلق بدون مصالحة
            ])->default('pending');

            // من طلب المصالحة أولاً؟
            $table->foreignId('reconciliation_requested_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atabs');
    }
};
