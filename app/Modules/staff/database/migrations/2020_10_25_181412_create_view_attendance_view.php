<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAttendanceView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW attendance_view
            AS
            SELECT
                attendances.attendance_id,
                    employees.id AS employee_id,   
                    employees.timetable_id,
                    MIN(CASE WHEN attendances.`status_attendance` = 'In' THEN attendances.`time_attendance`END) AS `clock_in`,
                    MAX(CASE WHEN attendances.`status_attendance` = 'Out' THEN attendances.`time_attendance`END) AS `clock_out`
                FROM
                attendances INNER JOIN employees ON attendances.attendance_id = employees.attendance_id
                WHERE employees.deleted_at IS NULL
                GROUP BY 
                CAST(`attendances`.`time_attendance` AS DATE ),
                attendance_id,employees.id,employees.timetable_id
             "
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_attendance_view');
    }
}
