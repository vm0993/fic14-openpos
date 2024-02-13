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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name',80);
            $table->string('address',120)->nullable();
            $table->string('phone_no',20)->nullable();
            $table->string('website',40)->nullable();
            $table->string('register_email',40)->nullable();
            $table->integer('outlet_qty')->default(0);
            $table->tinyInteger('login_common_disabled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
