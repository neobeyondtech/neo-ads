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
        Schema::create('partner_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('vehicle_brand_id');
            $table->string('vehicles_colour')->nullable();
            $table->year('vehicles_year')->nullable();

            $table->string('img_front')->nullable();
            $table->string('img_left')->nullable();
            $table->string('img_right')->nullable();
            $table->string('img_back')->nullable();
            $table->string('img_stnk')->nullable();

            $table->string('plat_number')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('partner_id');
            $table->index('type');
            $table->index('vehicle_brand_id');
            $table->index('plat_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_vehicles');
    }
};
