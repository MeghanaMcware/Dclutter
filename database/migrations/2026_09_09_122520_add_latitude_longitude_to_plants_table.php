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
        if (Schema::hasTable('plants')) {
            Schema::table('plants', function (Blueprint $table) {
                if (!Schema::hasColumn('plants', 'latitude')) {
                    $table->decimal('latitude', 10, 8)->nullable()->after('address');
                }
                if (!Schema::hasColumn('plants', 'longitude')) {
                    $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('plants')) {
            Schema::table('plants', function (Blueprint $table) {
                if (Schema::hasColumn('plants', 'latitude')) {
                    $table->dropColumn('latitude');
                }
                if (Schema::hasColumn('plants', 'longitude')) {
                    $table->dropColumn('longitude');
                }
            });
        }
    }
};
