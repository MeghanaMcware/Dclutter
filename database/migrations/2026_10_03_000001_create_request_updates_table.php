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
        Schema::create('request_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('dump_id')->nullable()->constrained('dumps')->nullOnDelete();
            
            $table->string('action')->index(); // created, assigned, before_pickup, picked_up, rescheduled, dumped, cancelled, etc.
            $table->string('status')->nullable()->index(); // pending, assigned, picked_up, not_available, dumped, rejected, etc.
            $table->decimal('approx_weight_kg', 8, 2)->nullable();
            $table->json('before_pickup_images')->nullable();
            $table->json('picked_up_images')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('remarks')->nullable();
            $table->text('not_available_reason')->nullable();
            $table->date('next_pickup_date')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_updates');
    }
};
