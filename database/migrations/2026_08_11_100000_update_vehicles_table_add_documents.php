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
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'vehicle_photo')) {
                $table->string('vehicle_photo')->nullable()->after('capacity_tons');
            }
            if (!Schema::hasColumn('vehicles', 'rc_document')) {
                $table->string('rc_document')->nullable()->after('vehicle_photo');
            }
            if (!Schema::hasColumn('vehicles', 'fitness_document')) {
                $table->string('fitness_document')->nullable()->after('rc_document');
            }
            if (!Schema::hasColumn('vehicles', 'insurance_document')) {
                $table->string('insurance_document')->nullable()->after('fitness_document');
            }
            if (!Schema::hasColumn('vehicles', 'driver_name')) {
                $table->string('driver_name')->nullable()->after('insurance_document');
            }
            if (!Schema::hasColumn('vehicles', 'driver_phone')) {
                $table->string('driver_phone', 10)->nullable()->after('driver_name');
            }
            if (!Schema::hasColumn('vehicles', 'license_number')) {
                $table->string('license_number')->nullable()->after('driver_phone');
            }
            if (!Schema::hasColumn('vehicles', 'license_photo')) {
                $table->string('license_photo')->nullable()->after('license_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_photo',
                'rc_document',
                'fitness_document',
                'insurance_document',
                'driver_name',
                'driver_phone',
                'license_number',
                'license_photo',
            ]);
        });
    }
};
