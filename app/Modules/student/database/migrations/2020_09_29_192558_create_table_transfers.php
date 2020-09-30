<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('leaved_date');
            $table->string('leave_reason');
            $table->enum('school_fees',['payed','not_payed'])->default('payed');
            $table->enum('school_books',['received','not_received'])->default('received');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('current_grade_id');
            $table->unsignedBigInteger('next_grade_id');
            $table->unsignedBigInteger('current_year_id');
            $table->unsignedBigInteger('next_year_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade')->onUpdate('cascade');                        
            $table->foreign('current_grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');                        
            $table->foreign('next_grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');                                    
            $table->foreign('current_year_id')->references('id')->on('years')->onDelete('cascade')->onUpdate('cascade');                        
            $table->foreign('next_year_id')->references('id')->on('years')->onDelete('cascade')->onUpdate('cascade');                                                
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('transfers');
    }
}
