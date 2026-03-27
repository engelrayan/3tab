<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->string('key', 80)->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed defaults
        $now = now();
        DB::table('system_settings')->insert([
            ['key' => 'allow_anonymous',        'value' => '1',  'created_at' => $now, 'updated_at' => $now],
            ['key' => 'allow_guest_sending',    'value' => '1',  'created_at' => $now, 'updated_at' => $now],
            ['key' => 'guest_rate_limit',       'value' => '5',  'created_at' => $now, 'updated_at' => $now],
            ['key' => 'auth_rate_limit',        'value' => '20', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'custom_blocked_words',   'value' => '[]', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
