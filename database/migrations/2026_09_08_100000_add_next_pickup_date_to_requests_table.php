<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('requests', 'next_pickup_date')) {
            Schema::table('requests', function (Blueprint $table) {
                $table->date('next_pickup_date')->nullable()->after('not_available_reason');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('requests', 'next_pickup_date')) {
            Schema::table('requests', function (Blueprint $table) {
                $table->dropColumn('next_pickup_date');
            });
        }
    }
};