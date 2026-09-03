<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('dumps')) {
            Schema::table('dumps', function (Blueprint $table) {
                if (!Schema::hasColumn('dumps', 'request_id')) {
                    $table->foreignId('request_id')->nullable()->after('vehicle_id')->constrained('requests')->nullOnDelete();
                }
                if (!Schema::hasColumn('dumps', 'pickup_number')) {
                    $table->string('pickup_number')->nullable()->after('request_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('dumps')) {
            Schema::table('dumps', function (Blueprint $table) {
                if (Schema::hasColumn('dumps', 'request_id')) {
                    $table->dropForeign(['request_id']);
                    $table->dropColumn('request_id');
                }
                if (Schema::hasColumn('dumps', 'pickup_number')) {
                    $table->dropColumn('pickup_number');
                }
            });
        }
    }
};
