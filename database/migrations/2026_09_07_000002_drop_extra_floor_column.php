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
        if (Schema::hasTable('requests') && Schema::hasColumn('requests', 'floor')) {
            Schema::table('requests', function (Blueprint $table) {
                $table->dropColumn('floor');
            });
        }

        if (Schema::hasTable('legacy_pickup_requests') && Schema::hasColumn('legacy_pickup_requests', 'floor')) {
            Schema::table('legacy_pickup_requests', function (Blueprint $table) {
                $table->dropColumn('floor');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('requests') && !Schema::hasColumn('requests', 'floor')) {
            Schema::table('requests', function (Blueprint $table) {
                $table->string('floor')->nullable()->after('house_no');
            });
        }

        if (Schema::hasTable('legacy_pickup_requests') && !Schema::hasColumn('legacy_pickup_requests', 'floor')) {
            Schema::table('legacy_pickup_requests', function (Blueprint $table) {
                $table->string('floor')->nullable()->after('address');
            });
        }
    }
};
