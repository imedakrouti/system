<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableHrReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_reports', function (Blueprint $table) {
            $table->text('header')->nullable();
            $table->text('footer')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_reports', function (Blueprint $table) {
            $table->dropColumn('header');
            $table->dropColumn('footer');            
        });
    }
}
