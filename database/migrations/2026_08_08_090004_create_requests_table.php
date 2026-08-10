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
        if (!Schema::hasTable('requests')) {
            Schema::create('requests', function (Blueprint $table) {
                $table->id();
                $table->string('request_number')->unique();
                $table->string('source')->default('citizen');
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('applicant_name');
                $table->string('mobile_number', 10);
                
                // Multi-select category & subcategory IDs or names
                $table->json('category_ids');
                $table->json('subcategory_ids')->nullable();
                
                // Photos
                $table->json('waste_images')->nullable();
                $table->json('picked_up_images')->nullable();
                
                // Address & Location Details
                $table->string('house_no');
                $table->text('address');
                $table->string('landmark')->nullable();
                $table->string('pincode', 6);
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->decimal('picked_up_latitude', 10, 8)->nullable();
                $table->decimal('picked_up_longitude', 11, 8)->nullable();
                
                // Municipal Hierarchy Foreign Keys
                $table->foreignId('corporation_id')->nullable()->constrained('corporations')->nullOnDelete();
                $table->foreignId('constituency_id')->nullable()->constrained('constituencies')->nullOnDelete();
                $table->foreignId('ward_id')->nullable()->constrained('wards')->nullOnDelete();
                
                // Pickup Scheduling & Vehicle Assignment
                $table->date('preferred_pickup_date');
                $table->string('status')->default('pending'); // pending, assigned, picked_up, dumped, rejected
                $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('picked_up_at')->nullable();
                $table->foreignId('dump_id')->nullable()->constrained('dumps')->nullOnDelete();
                
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
