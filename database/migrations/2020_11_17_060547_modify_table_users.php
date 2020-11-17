<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('preferredLanguage');
            $table->enum('lang',['ar','en'])->default('ar');
            $table->string('image_profile')->nullable();
            $table->string('ar_name')->nullable();
            $table->enum('domain_role',['parent','student'])->nullable();
        });
        Schema::connection('mysql2')->table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('preferredLanguage');
            $table->enum('lang',['ar','en'])->default('ar');
            $table->string('image_profile')->nullable();
            $table->string('ar_name')->nullable();
            $table->enum('domain_role',['parent','student'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('users', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('preferredLanguage')->default('en');
            $table->dropColumn('lang');
            $table->dropColumn('image_profile');
            $table->dropColumn('ar_name');
            $table->dropColumn('domain_role');
        });
        Schema::connection('mysql2')->table('users', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('preferredLanguage')->default('en');
            $table->dropColumn('lang');
            $table->dropColumn('image_profile');
            $table->dropColumn('ar_name');
            $table->dropColumn('domain_role');
        });
    }
}
