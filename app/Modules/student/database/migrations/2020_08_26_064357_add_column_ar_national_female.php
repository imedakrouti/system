<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnArNationalFemale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nationalities', function (Blueprint $table) {
            $table->dropColumn('ar_name_nationality');
            $table->string('ar_name_nat_male',50);
            $table->string('ar_name_nat_female',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nationalities', function (Blueprint $table) {
            $table->string('ar_name_nationality',50);
            $table->dropColumn('ar_name_nat_male');
            $table->dropColumn('ar_name_nat_female');
            
        });
    }
}
