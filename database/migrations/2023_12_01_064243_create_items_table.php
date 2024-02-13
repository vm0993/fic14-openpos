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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id')->default(0);
            $table->foreignId('categori_id')->constrained('categoris');
            $table->string('code',15);
            $table->string('name',60);
            $table->decimal('sale_amount',18,2)->default(0);
            $table->foreignId('unit_id')->constrained('units');
            $table->string('sku',25)->nullable();
            $table->string('barcode',30)->nullable();
            $table->string('item_image',70)->nullable();
            $table->boolean('item_purchase')->default(0)->comment('1 : Dijual, 0 : Tidak');
            $table->boolean('item_sale')->default(0)->comment('1 : Dijual, 0 : Tidak');
            $table->boolean('item_stock')->default(0)->comment('1 : Inventory, 0 : Non Inventory');
            $table->boolean('check_inventory')->default(0)->comment('1 : Inventory Check, 0 : Non Inventory Check');
            $table->enum('item_type',['TUNGGAL','KOMPOSISI'])->default('TUNGGAL');
            $table->enum('status',['AKTIF','SUSPEND'])->default('AKTIF');
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            //$table->foreign('outlet_id')->references('id')->on('outlets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
