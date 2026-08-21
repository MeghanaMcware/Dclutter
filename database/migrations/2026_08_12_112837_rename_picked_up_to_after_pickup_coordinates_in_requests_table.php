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
        Schema::table('requests', function (Blueprint $table) {
            if (Schema::hasColumn('requests', 'picked_up_latitude')) {
                $table->renameColumn('picked_up_latitude', 'after_pickup_latitude');
            }
            if (Schema::hasColumn('requests', 'picked_up_longitude')) {
                $table->renameColumn('picked_up_longitude', 'after_pickup_longitude');
            }
            if (!Schema::hasColumn('requests', 'before_pickup_latitude')) {
                $table->decimal('before_pickup_latitude', 10, 8)->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('requests', 'before_pickup_longitude')) {
                $table->decimal('before_pickup_longitude', 11, 8)->nullable()->after('before_pickup_latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            if (Schema::hasColumn('requests', 'after_pickup_latitude')) {
                $table->renameColumn('after_pickup_latitude', 'picked_up_latitude');
            }
            if (Schema::hasColumn('requests', 'after_pickup_longitude')) {
                $table->renameColumn('after_pickup_longitude', 'picked_up_longitude');
            }
            if (Schema::hasColumn('requests', 'before_pickup_latitude')) {
                $table->dropColumn('before_pickup_latitude');
            }
            if (Schema::hasColumn('requests', 'before_pickup_longitude')) {
                $table->dropColumn('before_pickup_longitude');
            }
        });
    }
};
