<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moods', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('emoji', 10);
            $table->string('color', 7)->default('#C8923A'); // hex color
            $table->string('hint_ar')->nullable();          // "كن رفيقاً في كلامك"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moods');
    }
};
