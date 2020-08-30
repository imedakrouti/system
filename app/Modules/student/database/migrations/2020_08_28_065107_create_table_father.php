<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fathers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_st_name',30);
            $table->string('ar_nd_name',30);
            $table->string('ar_rd_name',30);
            $table->string('ar_th_name',30);
            $table->string('en_st_name',30);
            $table->string('en_nd_name',30);
            $table->string('en_rd_name',30);
            $table->string('en_th_name',30);
            $table->enum('id_type',['national_id','passport'])->default('national_id');
            $table->string('id_number',15)->unique();
            $table->string('home_phone',11)->nullable();
            $table->string('mobile1',15)->unique();
            $table->string('mobile2',15)->nullable();
            $table->string('job',75);
            $table->string('email',75)->nullable()->unique();
            $table->string('qualification',75);
            $table->string('facebook',50)->nullable();
            $table->string('whatsapp_number',15)->nullable()->unique();
            $table->unsignedBigInteger('nationality_id');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('religion',['muslim','non_muslim'])->default('muslim');
            $table->enum('educational_mandate',['father','mother'])->default('father');
            $table->string('block_no',5);
            $table->string('street_name',50);
            $table->string('state',30);
            $table->string('government',30);
            $table->enum('marital_status',['married','divorced','separated','widower'])->default('married');
            $table->enum('recognition',['facebook','street','parent','school_hub'])->default('facebook');
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
        Schema::dropIfExists('fathers');
    }
}
