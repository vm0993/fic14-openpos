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
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('code',15);
            $table->string('name',60);
            $table->string('address',120)->nullable();
            $table->string('phone_no',20)->nullable();
            $table->string('email',40)->nullable();
            $table->enum('status',['AKTIF','SUSPEND'])->default('AKTIF');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
