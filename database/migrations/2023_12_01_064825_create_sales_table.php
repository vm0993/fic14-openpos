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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id')->default(0);
            $table->unsignedBigInteger('customer_id')->default(0);
            $table->string('code',30);
            $table->date('transaction_date');
            $table->unsignedBigInteger('promo_id')->default(0);
            $table->decimal('sub_total',18,2)->default(0);
            $table->decimal('discount_amount',18,2)->default(0);
            $table->decimal('sevice_charge_amount',18,2)->default(0);
            $table->decimal('tax_amount',18,2)->default(0);
            $table->decimal('grand_total',18,2)->default(0);
            $table->enum('type',['DINE IN','TAKE WAY','ONLINE'])->default('DINE IN');
            $table->enum('status',['OPEN','PAID','COMPLIMENT'])->default('OPEN');
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('outlet_id')->references('id')->on('outlets');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('promo_id')->references('id')->on('promos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
