<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            // توكن الزائر (بدون حساب) — unique مع index للبحث السريع
            $table->string('guest_token', 60)->nullable()->unique()->after('token');

            // أول فتح من المستلم — لنظام "تم المشاهدة"
            $table->timestamp('seen_at')->nullable()->after('claimed_at');
        });
    }

    public function down(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            $table->dropColumn(['guest_token', 'seen_at']);
        });
    }
};
