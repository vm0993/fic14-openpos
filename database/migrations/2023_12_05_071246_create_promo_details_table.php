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
        Schema::create('promo_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promo_id');
            $table->string('voucher_promo',8);
            $table->enum('status',['APPLY',''])->default('');
            $table->dateTime('apply_date')->nullable();
            $table->timestamps();

            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_details');
    }
};
