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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();

            $table->date('birth_date')->nullable();
            $table->string('phone', 30)->nullable();

            $table->string('no_ktp', 50)->nullable();
            $table->string('img_ktp', 255)->nullable();

            $table->string('no_sim', 50)->nullable();
            $table->string('img_sim', 255)->nullable();

            $table->unsignedBigInteger('subdistrict_id')->nullable();
            $table->text('address')->nullable();
            $table->string('status', 50)->default('draft');
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('phone');
            $table->index('no_ktp');
            $table->index('no_sim');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
