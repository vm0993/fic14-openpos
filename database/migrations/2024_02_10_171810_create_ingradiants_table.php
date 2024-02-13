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
        Schema::create('ingradiants', function (Blueprint $table) {
            $table->id();
            $table->string('code',20);
            $table->string('description',120)->nullable();
            $table->decimal('cost_amount',18,2)->default(0);
            $table->enum('status',['AKTIF','SUSPEND'])->default('AKTIF');
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingradiants');
    }
};
