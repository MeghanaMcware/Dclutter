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
        if (!Schema::hasTable('dumps')) {
            Schema::create('dumps', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
                $table->string('plant_name')->nullable();
                $table->decimal('dump_weight', 10, 2)->nullable();
                $table->json('dump_images')->nullable();
                $table->decimal('dump_latitude', 10, 8)->nullable();
                $table->decimal('dump_longitude', 11, 8)->nullable();
                $table->timestamp('dumped_at')->useCurrent();
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
        Schema::dropIfExists('dumps');
    }
};
