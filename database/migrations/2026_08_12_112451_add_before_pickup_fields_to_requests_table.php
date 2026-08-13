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
            if (!Schema::hasColumn('requests', 'before_pickup_images')) {
                $table->json('before_pickup_images')->nullable()->after('picked_up_images');
            }
            if (!Schema::hasColumn('requests', 'approx_weight_kg')) {
                $table->decimal('approx_weight_kg', 8, 2)->nullable()->after('before_pickup_images');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            if (Schema::hasColumn('requests', 'before_pickup_images')) {
                $table->dropColumn('before_pickup_images');
            }
            if (Schema::hasColumn('requests', 'approx_weight_kg')) {
                $table->dropColumn('approx_weight_kg');
            }
        });
    }
};
