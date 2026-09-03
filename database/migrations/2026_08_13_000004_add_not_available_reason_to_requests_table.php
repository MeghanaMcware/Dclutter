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
        if (Schema::hasTable('requests')) {
            Schema::table('requests', function (Blueprint $table) {
                if (!Schema::hasColumn('requests', 'not_available_reason')) {
                    $table->text('not_available_reason')->nullable()->after('remarks');
                }
                if (!Schema::hasColumn('requests', 'not_available_at')) {
                    $table->timestamp('not_available_at')->nullable()->after('not_available_reason');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('requests')) {
            Schema::table('requests', function (Blueprint $table) {
                if (Schema::hasColumn('requests', 'not_available_reason')) {
                    $table->dropColumn('not_available_reason');
                }
                if (Schema::hasColumn('requests', 'not_available_at')) {
                    $table->dropColumn('not_available_at');
                }
            });
        }
    }
};
