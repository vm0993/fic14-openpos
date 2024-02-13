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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->foreignId('item_id')->constrained('items');
            $table->integer('qty')->default(0);
            $table->decimal('sale_price',18,2)->default(0);
            $table->decimal('discount',18,2)->default(0);
            $table->timestamps();

            /* $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('item_id')->references('id')->on('items'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
