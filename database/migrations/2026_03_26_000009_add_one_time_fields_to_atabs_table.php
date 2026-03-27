<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            $table->boolean('is_one_time')->default(false)->after('is_flagged');
            $table->timestamp('opened_at')->nullable()->after('is_one_time');
        });
    }

    public function down(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            $table->dropColumn(['is_one_time', 'opened_at']);
        });
    }
};
