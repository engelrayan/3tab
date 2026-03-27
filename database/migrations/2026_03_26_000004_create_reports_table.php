<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atab_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reporter_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reporter_ip', 45)->nullable();
            $table->string('reason', 120)->nullable();
            $table->timestamps();

            // one report per user/IP per atab
            $table->unique(['atab_id', 'reporter_user_id']);
            $table->index(['atab_id', 'reporter_ip']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
