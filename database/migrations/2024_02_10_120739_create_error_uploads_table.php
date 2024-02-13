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
        Schema::create('error_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('description',80)->nullable();
            $table->string('upload_filename',120);
            $table->string('attribute')->nullable();
            $table->unsignedInteger('row')->default(0);
            $table->json('values')->nullable();
            $table->json('errors')->nullable();
            $table->string('module')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_uploads');
    }
};
