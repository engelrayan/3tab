<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            // رابط قابل للمشاركة
            $table->string('token', 64)->nullable()->unique()->after('id')->index();

            // analytics
            $table->unsignedInteger('views_count')->default(0)->after('status');
            $table->timestamp('claimed_at')->nullable()->after('views_count');
            $table->timestamp('expires_at')->nullable()->after('claimed_at');
        });
    }

    public function down(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            $table->dropColumn(['token', 'views_count', 'claimed_at', 'expires_at']);
        });
    }
};
