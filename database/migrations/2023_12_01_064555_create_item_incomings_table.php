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
        Schema::create('item_incomings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->string('code',30);
            $table->date('transaction_date');
            $table->string('description',80)->nullable();
            $table->decimal('total_qty',18,2)->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('outlet_id')->references('id')->on('outlets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_incomings');
    }
};
