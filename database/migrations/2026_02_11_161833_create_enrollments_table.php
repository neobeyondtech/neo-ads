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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id(); // Submission ID

            $table->unsignedBigInteger('partner_id'); 
            $table->unsignedBigInteger('ad_id'); 

            $table->string('status')->default('pending'); 
            $table->text('remarks')->nullable(); 

            $table->decimal('rate', 5, 2)->nullable(); 
            $table->string('achievement')->nullable(); 

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('partner_id');
            $table->index('ad_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
