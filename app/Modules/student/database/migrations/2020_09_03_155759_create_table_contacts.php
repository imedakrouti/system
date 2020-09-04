<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('relative_name',30);
            $table->string('relative_mobile',15);
            $table->string('relative_notes')->nullable();
            $table->enum('relative_relation',['grand_pa','grand_ma','uncle','aunt','neighbor','other']);
            $table->unsignedBigInteger('father_id');
            $table->foreign('father_id')->references('id')->on('fathers')->on('students')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('contacts');
    }
}
