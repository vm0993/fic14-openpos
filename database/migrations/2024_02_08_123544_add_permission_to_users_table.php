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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('company_id')->default(0)->after('user_type');
            $table->integer('permission_group_id')->default(0)->after('company_id');
            $table->integer('pegawai_id')->default(0)->after('permission_group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pegawai_id');
            $table->dropColumn('permission_group_id');
            $table->dropColumn('company_id');
        });
    }
};
