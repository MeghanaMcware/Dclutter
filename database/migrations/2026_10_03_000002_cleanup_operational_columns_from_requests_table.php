<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Backfill any existing operational data from requests to request_updates
        if (Schema::hasTable('requests') && Schema::hasTable('request_updates')) {
            $existingRequests = DB::table('requests')->get();
            foreach ($existingRequests as $req) {
                // If has before pickup data
                if (!empty($req->before_pickup_images) || !empty($req->approx_weight_kg) || !empty($req->before_pickup_latitude)) {
                    $hasBeforeLog = DB::table('request_updates')->where('request_id', $req->id)->where('action', 'before_pickup')->exists();
                    if (!$hasBeforeLog) {
                        DB::table('request_updates')->insert([
                            'request_id' => $req->id,
                            'vehicle_id' => $req->vehicle_id,
                            'action' => 'before_pickup',
                            'status' => $req->status,
                            'approx_weight_kg' => $req->approx_weight_kg,
                            'before_pickup_images' => $req->before_pickup_images,
                            'latitude' => $req->before_pickup_latitude,
                            'longitude' => $req->before_pickup_longitude,
                            'remarks' => 'Driver completed before-pickup inspection',
                            'created_at' => $req->updated_at ?? now(),
                            'updated_at' => $req->updated_at ?? now(),
                        ]);
                    }
                }

                // If has after pickup data
                if (!empty($req->picked_up_images) || !empty($req->picked_up_at) || !empty($req->after_pickup_latitude)) {
                    $hasAfterLog = DB::table('request_updates')->where('request_id', $req->id)->where('action', 'picked_up')->exists();
                    if (!$hasAfterLog) {
                        DB::table('request_updates')->insert([
                            'request_id' => $req->id,
                            'vehicle_id' => $req->vehicle_id,
                            'action' => 'picked_up',
                            'status' => 'picked_up',
                            'picked_up_images' => $req->picked_up_images,
                            'latitude' => $req->after_pickup_latitude,
                            'longitude' => $req->after_pickup_longitude,
                            'remarks' => 'Waste loaded on vehicle and marked picked up',
                            'created_at' => $req->picked_up_at ?? ($req->updated_at ?? now()),
                            'updated_at' => $req->picked_up_at ?? ($req->updated_at ?? now()),
                        ]);
                    }
                }

                // If has reschedule/not available data
                if (!empty($req->not_available_reason) || !empty($req->not_available_at)) {
                    $hasRescheduleLog = DB::table('request_updates')->where('request_id', $req->id)->where('action', 'rescheduled')->exists();
                    if (!$hasRescheduleLog) {
                        DB::table('request_updates')->insert([
                            'request_id' => $req->id,
                            'vehicle_id' => $req->vehicle_id,
                            'action' => 'rescheduled',
                            'status' => 'not_available',
                            'not_available_reason' => $req->not_available_reason,
                            'next_pickup_date' => $req->next_pickup_date,
                            'remarks' => 'Pickup rescheduled: ' . $req->not_available_reason,
                            'created_at' => $req->not_available_at ?? ($req->updated_at ?? now()),
                            'updated_at' => $req->not_available_at ?? ($req->updated_at ?? now()),
                        ]);
                    }
                }
            }
        }

        // 2. Drop redundant operational columns from requests table
        Schema::table('requests', function (Blueprint $table) {
            $colsToDrop = [];
            foreach ([
                'before_pickup_images',
                'picked_up_images',
                'approx_weight_kg',
                'before_pickup_latitude',
                'before_pickup_longitude',
                'after_pickup_latitude',
                'after_pickup_longitude',
                'not_available_reason',
                'not_available_at',
            ] as $col) {
                if (Schema::hasColumn('requests', $col)) {
                    $colsToDrop[] = $col;
                }
            }

            if (!empty($colsToDrop)) {
                $table->dropColumn($colsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->json('picked_up_images')->nullable()->after('waste_images');
            $table->json('before_pickup_images')->nullable()->after('picked_up_images');
            $table->decimal('approx_weight_kg', 8, 2)->nullable()->after('before_pickup_images');
            $table->decimal('before_pickup_latitude', 10, 8)->nullable()->after('longitude');
            $table->decimal('before_pickup_longitude', 11, 8)->nullable()->after('before_pickup_latitude');
            $table->decimal('after_pickup_latitude', 10, 8)->nullable()->after('before_pickup_longitude');
            $table->decimal('after_pickup_longitude', 11, 8)->nullable()->after('after_pickup_latitude');
            $table->text('not_available_reason')->nullable()->after('remarks');
            $table->dateTime('not_available_at')->nullable()->after('next_pickup_date');
        });
    }
};
