<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('student_type',['applicant','student'])->default('applicant');
            $table->string('ar_student_name',20);
            $table->string('en_student_name',20);
            $table->enum('id_type',['national_id','passport'])->default('national_id');
            $table->string('id_number',15)->uniqid();
            $table->enum('gender',['male','female'])->default('male');
            $table->enum('religion',['muslim','non_muslim'])->default('muslim');
            $table->unsignedBigInteger('native_lang_id');
            $table->unsignedBigInteger('second_lang_id');
            $table->enum('term',['all','first','second'])->default('all');
            $table->date('dob');
            $table->enum('reg_type',['return','arrival','noob','transfer'])->default('noob');
            $table->string('student_image',75)->nullable();
            $table->string('submitted_application',75)->nullable();
            $table->string('submitted_name',75)->nullable();
            $table->string('submitted_id_number',15)->nullable();
            $table->string('submitted_mobile',15)->nullable();
            $table->date('application_date')->nullable();
            $table->string('place_birth',30)->nullable();
            $table->string('return_country',30)->nullable();            
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('registration_status_id');
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('father_id');
            $table->unsignedBigInteger('mother_id');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('native_lang_id')->references('id')->on('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('second_lang_id')->references('id')->on('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('registration_status_id')->references('id')->on('registration_status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('father_id')->references('id')->on('fathers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mother_id')->references('id')->on('mothers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('students');
    }
}
