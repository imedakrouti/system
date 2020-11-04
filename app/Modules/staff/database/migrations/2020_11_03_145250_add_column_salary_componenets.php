<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSalaryComponenets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('salary_components', function (Blueprint $table) {
            $table->unsignedBigInteger('payroll_sheet_id');            
        });
        Schema::connection('mysql2')->table('salary_components', function (Blueprint $table) {
            $table->unsignedBigInteger('payroll_sheet_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('salary_components', function (Blueprint $table) {            
            $table->dropColumn('payroll_sheet_id');
        });
        Schema::connection('mysql2')->table('salary_components', function (Blueprint $table) {            
            $table->dropColumn('payroll_sheet_id');
        });
    }
}
