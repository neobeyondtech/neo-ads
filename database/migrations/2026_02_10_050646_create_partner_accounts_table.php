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
        Schema::create('partner_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('account_name', 255);
            $table->string('account_number', 100);
            $table->unsignedBigInteger('bank_id');
            $table->string('account_owner', 255);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('partner_id');
            $table->index('bank_id');
            $table->index('account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_accounts');
    }
};
