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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_logo',30)->nullable()->after('register_email');
            $table->decimal('service_charges_rate',18,2)->default(0)->after('company_logo');
            //$table->unsignedBigInteger('service_charges_account_id')->default(0)->after('service_charges_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            //$table->dropColumn('service_charges_account_id');
            $table->dropColumn('service_charges_rate');
            $table->dropColumn('company_logo');
        });
    }
};
