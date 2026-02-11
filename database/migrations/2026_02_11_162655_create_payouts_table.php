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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id(); // id

            $table->unsignedBigInteger('advertisement_id');
            $table->unsignedBigInteger('partner_id');

            $table->decimal('amount', 15, 2);

            $table->string('payment_status');   
            $table->string('payment_method');   
            
            // Additional payment details
            $table->dateTime('payment_date')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->string('payment_channel')->nullable(); 
            $table->text('payment_notes')->nullable();
            
            $table->timestamps(); 
            $table->softDeletes(); 

            $table->index('advertisement_id');
            $table->index('partner_id');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
