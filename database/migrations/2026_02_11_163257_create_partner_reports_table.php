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
        Schema::create('partner_reports', function (Blueprint $table) {
            $table->id(); // Report ID

            $table->unsignedBigInteger('ad_id');       
            $table->unsignedBigInteger('partner_id');  

            // Images
            $table->string('img_vehicle_stickers')->nullable();  
            $table->string('img_odometer')->nullable();    

            $table->integer('actual_odoometer')->nullable();   

            // Additional details
            $table->string('status')->default('pending'); 
            $table->text('remarks')->nullable();     
            $table->string('location')->nullable();   
            
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('reviewed_at')->nullable();

            $table->timestamps();
            $table->softDeletes(); 

            $table->index('ad_id');
            $table->index('partner_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_reports');
    }
};
