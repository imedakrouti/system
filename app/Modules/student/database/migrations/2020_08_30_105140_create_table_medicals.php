<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMedicals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('blood_type',['unknown','-O','+O','-A','+A','-B','+B','-AB','+AB'])->default('unknown');
            $table->enum('food_sensitivity',['yes','no'])->default('no');
            $table->enum('medicine_sensitivity',['yes','no'])->default('no');
            $table->enum('other_sensitivity',['yes','no'])->default('no');
            $table->enum('have_medicine',['yes','no'])->default('no');
            $table->enum('vision_problem',['yes','no'])->default('no');
            $table->enum('use_glasses',['yes','no'])->default('no');
            $table->enum('hearing_problems',['yes','no'])->default('no');
            $table->enum('speaking_problems',['yes','no'])->default('no');
            $table->enum('chest_pain',['yes','no'])->default('no');
            $table->enum('breath_problem',['yes','no'])->default('no');
            $table->enum('asthma',['yes','no'])->default('no');
            $table->enum('have_asthma_medicine',['yes','no'])->default('no');
            $table->enum('heart_problem',['yes','no'])->default('no');
            $table->enum('hypertension',['yes','no'])->default('no');
            $table->enum('diabetic',['yes','no'])->default('no');
            $table->enum('anemia',['yes','no'])->default('no');
            $table->enum('cracking_blood',['yes','no'])->default('no');
            $table->enum('coagulation',['yes','no'])->default('no');
            $table->string('food_sensitivity_note')->nullable();
            $table->string('medicine_sensitivity_note')->nullable();
            $table->string('other_sensitivity_note')->nullable();
            $table->string('have_medicine_note')->nullable();
            $table->string('vision_problem_note')->nullable();
            $table->string('use_glasses_note')->nullable();
            $table->string('hearing_problems_note')->nullable();
            $table->string('speaking_problems_note')->nullable();
            $table->string('chest_pain_note')->nullable();
            $table->string('breath_problem_note')->nullable();
            $table->string('asthma_note')->nullable();
            $table->string('have_asthma_medicine_note')->nullable();
            $table->string('heart_problem_note')->nullable();
            $table->string('hypertension_note')->nullable();
            $table->string('diabetic_note')->nullable();
            $table->string('anemia_note')->nullable();
            $table->string('cracking_blood_note')->nullable();
            $table->string('coagulation_note')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('medicals');
    }
}
