<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGuaridans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('guardian_full_name',75);
            $table->enum('guardian_guardian_type',['guardian','grand_pa','grand_ma','uncle','aunt'])->default('guardian');
            $table->enum('guardian_id_type',['national_id','passport'])->default('national_id');
            $table->string('guardian_id_number',15)->unique();
            $table->string('guardian_mobile1',15)->unique();
            $table->string('guardian_mobile2',15)->nullable();
            $table->string('guardian_job',75);
            $table->string('guardian_email',75)->nullable()->unique();
            $table->string('guardian_block_no',5);
            $table->string('guardian_street_name',50);
            $table->string('guardian_state',30);
            $table->string('guardian_government',30);
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
        Schema::dropIfExists('guardians');
    }
}
