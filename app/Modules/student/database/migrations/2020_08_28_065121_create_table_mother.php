<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMother extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mothers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name',75);
            $table->enum('id_type_m',['national_id','passport'])->default('national_id');
            $table->string('id_number_m',15)->uniqid();
            $table->string('home_phone_m',11)->nullable();
            $table->string('mobile1_m',15)->uniqid();
            $table->string('mobile2_m',15)->nullable();
            $table->string('job_m',75);
            $table->string('email_m',75)->nullable()->uniqid();
            $table->string('qualification_m',75);
            $table->string('facebook_m',50)->nullable();
            $table->string('whatsapp_number_m',15)->nullable()->uniqid();
            $table->unsignedBigInteger('nationality_id_m');
            $table->foreign('nationality_id_m')->references('id')->on('nationalities')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('religion_m',['muslim','non_muslim'])->default('muslim');
            $table->string('block_no_m',5);
            $table->string('street_name_m',50);
            $table->string('state_m',30);
            $table->string('government_m',30);            
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mothers');
    }
}
