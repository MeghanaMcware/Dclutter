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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->change();
            }
            if (!Schema::hasColumn('users', 'mobile_number')) {
                $table->string('mobile_number', 10)->after('email');
            }
            if (!Schema::hasColumn('users', 'corporation_ids')) {
                $table->json('corporation_ids')->nullable();
            }
            if (!Schema::hasColumn('users', 'constituency_ids')) {
                $table->json('constituency_ids')->nullable();
            }
            if (!Schema::hasColumn('users', 'ward_ids')) {
                $table->json('ward_ids')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'ward_ids')) {
                $table->dropColumn(['corporation_ids', 'constituency_ids', 'ward_ids']);
            }
            if (Schema::hasColumn('users', 'mobile_number')) {
                $table->dropColumn('mobile_number');
            }
        });
    }
};
