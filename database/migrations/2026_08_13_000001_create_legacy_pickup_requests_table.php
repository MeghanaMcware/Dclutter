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
        Schema::create('legacy_pickup_requests', function (Blueprint $table) {
            $table->id(); // Starts from 1 continuously
            $table->unsignedBigInteger('excel_id')->nullable()->index();
            $table->string('applicant_name')->nullable();
            $table->string('mobile_number', 20)->nullable()->index();
            $table->text('address')->nullable();
            $table->string('corporation_name')->nullable();
            $table->string('division_name')->nullable();
            $table->string('ward_name_no')->nullable();
            $table->foreignId('corporation_id')->nullable()->constrained('corporations')->nullOnDelete();
            $table->foreignId('constituency_id')->nullable()->constrained('constituencies')->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->constrained('wards')->nullOnDelete();
            $table->dateTime('preferred_pickup_date')->nullable();
            $table->text('items_text')->nullable();
            $table->json('category_ids')->nullable();
            $table->string('status')->default('pending')->index(); // pending, assigned, picked_up
            $table->string('created_at_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legacy_pickup_requests');
    }
};
