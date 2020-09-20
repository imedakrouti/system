<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEducationAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ar_education_administration')->nullable();
            $table->string('en_education_administration')->nullable();
            $table->string('ar_governorate')->nullable();
            $table->string('en_governorate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('ar_education_administration');
            $table->dropColumn('en_education_administration');
            $table->dropColumn('ar_governorate');
            $table->dropColumn('en_governorate');
        });
    }
}
