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
        Schema::create('item_incoming_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_incoming_id')->constrained('item_incomings');
            $table->foreignId('item_id')->constrained('items');
            $table->decimal('qty',18,2)->default(0);
            $table->decimal('buy_price',18,2)->default(0);
            $table->timestamps();

            /* $table->foreign('item_incoming_id')->references('id')->on('item_incomings');
            $table->foreign('item_id')->references('id')->on('items'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_incoming_details');
    }
};
