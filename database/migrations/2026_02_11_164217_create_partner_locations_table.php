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
        Schema::create('partner_locations', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->unsignedBigInteger('partner_id'); // Partner reference

            // GPS coordinates
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            // Optional data from Google Maps
            $table->decimal('speed', 8, 2)->nullable();        // Speed in km/h
            $table->decimal('heading', 5, 2)->nullable();      // Direction in degrees
            $table->decimal('accuracy', 5, 2)->nullable();     // GPS accuracy in meters
            $table->decimal('altitude', 8, 2)->nullable();     // Altitude if available

            $table->string('status')->default('active');       // active, idle, stopped
            $table->text('remarks')->nullable();                 // optional notes

            $table->timestamp('recorded_at');                  // Time the location was recorded
            $table->timestamps();
            $table->softDeletes();

            $table->index('partner_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_locations');
    }
};
