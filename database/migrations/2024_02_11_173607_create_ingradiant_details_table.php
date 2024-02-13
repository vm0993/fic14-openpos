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
        Schema::create('ingradiant_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingradiant_id')->constrained('ingradiants');
            $table->foreignId('item_id')->constrained('items');
            $table->decimal('qty_usage',18,4)->default(0);
            $table->decimal('cost_usage',18,2)->default(0);
            $table->string('note',120)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingradiant_details');
    }
};
