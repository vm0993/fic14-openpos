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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route_name',190)->nullable();
            $table->string('icon',60)->nullable();
            $table->integer('menu_order')->default(0);
            $table->integer('parent_id')->default(0);
            $table->enum('is_child',['NO','CHILD','SUBCHILD'])->default('NO');
            $table->enum('activate',['YES','NO'])->default('NO');
            $table->enum('access_menu',['YES','NO'])->default('NO');
            $table->enum('integration_status',['YES','NO'])->default('NO');
            $table->enum('report_menu',['YES','NO'])->default('NO');
            $table->enum('view_menu',['YES','NO'])->default('NO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
