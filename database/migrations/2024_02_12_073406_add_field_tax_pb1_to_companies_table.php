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
            $table->decimal('resto_tax_rate',18,2)->default(0)->after('service_charges_rate');
            //$table->unsignedBigInteger('resto_tax_account_id')->default(0)->after('resto_tax_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            //$table->dropColumn('resto_tax_account_id');
            $table->dropColumn('resto_tax_rate');
        });
    }
};
