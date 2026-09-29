<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('vehicles')) {
            if (!Schema::hasColumn('vehicles', 'constituency_ids')) {
                Schema::table('vehicles', function (Blueprint $table) {
                    $table->json('constituency_ids')->nullable();
                });
            }

            // Migrate existing single constituency_id data to constituency_ids if any
            if (Schema::hasColumn('vehicles', 'constituency_id')) {
                $vehicles = DB::table('vehicles')->whereNotNull('constituency_id')->get();
                foreach ($vehicles as $v) {
                    if (empty($v->constituency_ids)) {
                        DB::table('vehicles')->where('id', $v->id)->update([
                            'constituency_ids' => json_encode([(int) $v->constituency_id])
                        ]);
                    }
                }

                Schema::table('vehicles', function (Blueprint $table) {
                    try {
                        $table->dropForeign(['constituency_id']);
                    } catch (\Throwable $e) {
                        // Ignore if FK not defined
                    }
                    $table->dropColumn('constituency_id');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('vehicles') && !Schema::hasColumn('vehicles', 'constituency_id')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->unsignedBigInteger('constituency_id')->nullable();
            });
        }
    }
};
