<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            $table->enum('reconciliation_status', ['none', 'requested', 'accepted', 'rejected'])
                  ->default('none')
                  ->after('reconciliation_requested_by');
            $table->timestamp('reconciliation_requested_at')->nullable()->after('reconciliation_status');
            $table->timestamp('reconciliation_confirmed_at')->nullable()->after('reconciliation_requested_at');
        });
    }

    public function down(): void
    {
        Schema::table('atabs', function (Blueprint $table) {
            $table->dropColumn([
                'reconciliation_status',
                'reconciliation_requested_at',
                'reconciliation_confirmed_at',
            ]);
        });
    }
};
