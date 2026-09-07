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
        if (Schema::hasTable('requests') && !Schema::hasColumn('requests', 'floor_no')) {
            Schema::table('requests', function (Blueprint $table) {
                $table->string('floor_no')->nullable()->after('house_no');
            });
        }

        if (Schema::hasTable('legacy_pickup_requests') && !Schema::hasColumn('legacy_pickup_requests', 'floor_no')) {
            Schema::table('legacy_pickup_requests', function (Blueprint $table) {
                $table->string('floor_no')->nullable()->after('address');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('requests') && Schema::hasColumn('requests', 'floor_no')) {
            Schema::table('requests', function (Blueprint $table) {
                $table->dropColumn('floor_no');
            });
        }

        if (Schema::hasTable('legacy_pickup_requests') && Schema::hasColumn('legacy_pickup_requests', 'floor_no')) {
            Schema::table('legacy_pickup_requests', function (Blueprint $table) {
                $table->dropColumn('floor_no');
            });
        }
    }
};
