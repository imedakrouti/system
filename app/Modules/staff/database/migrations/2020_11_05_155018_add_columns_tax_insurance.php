<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTaxInsurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('employees', function (Blueprint $table) {
            $table->decimal('insurance_value')->nullable();
            $table->decimal('tax_value')->nullable();
        });
        Schema::connection('mysql2')->table('employees', function (Blueprint $table) {
            $table->decimal('insurance_value')->nullable();
            $table->decimal('tax_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('employees', function (Blueprint $table) {
            $table->dropColumn('insurance_value');
            $table->dropColumn('tax_value');
        });
        Schema::connection('mysql2')->table('employees', function (Blueprint $table) {
            $table->dropColumn('insurance_value');
            $table->dropColumn('tax_value');
        });
    }
}
