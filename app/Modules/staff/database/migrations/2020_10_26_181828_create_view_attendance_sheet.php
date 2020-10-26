<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAttendanceSheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW attendance_sheet
            AS
            SELECT
                attendance_view.attendance_id,
                IF(`attendance_view`.`clock_in` IS NOT NULL,CAST(`attendance_view`.`clock_in` AS DATE),CAST(`attendance_view`.`clock_out` AS DATE)) AS `Date`,
                IF(`attendance_view`.`clock_in` IS NOT NULL,CAST(`attendance_view`.`clock_in` AS TIME),'') AS `clock_in`,
                IF(`attendance_view`.`clock_out` IS NOT NULL,CAST(`attendance_view`.`clock_out` AS TIME),'') AS `clock_out`,
                IF(`attendance_view`.`clock_in` IS NOT NULL AND `attendance_view`.`clock_out` IS NOT NULL,
                        TIMEDIFF(CAST(`attendance_view`.`clock_out` AS TIME),CAST(`attendance_view`.`clock_in` AS TIME)),'') AS `work_time`,

                IF(TIMEDIFF(CAST(`attendance_view`.`clock_in` AS TIME),timetables.`on_duty_time`) > 0,
                        TIMEDIFF(CAST(`attendance_view`.`clock_in` AS TIME),timetables.`on_duty_time`),'') AS `lates`,

                IF((`attendance_view`.`clock_in` IS NOT NULL) AND (TIMEDIFF(CAST(`attendance_view`.`clock_in` AS TIME),timetables.`on_duty_time`) > 0) ,
                   CAST(TIME_TO_SEC(TIMEDIFF(CAST(`attendance_view`.`clock_in` AS TIME),timetables.`on_duty_time`)) / 60 AS signed)
                   ,0)
                   AS `minutes`,

                IF(TIMEDIFF(timetables.`off_duty_time`,CAST(`attendance_view`.`clock_out` AS TIME)) > 0,
                        TIMEDIFF(timetables.`off_duty_time`,CAST(`attendance_view`.`clock_out` AS TIME)),'') AS `leave_early`,


                IF((`attendance_view`.`clock_out` IS NOT NULL) AND (TIMEDIFF(timetables.`off_duty_time`,CAST(`attendance_view`.`clock_out` AS TIME)) > 0),
                   CAST(TIME_TO_SEC(TIMEDIFF(timetables.`off_duty_time`,CAST(`attendance_view`.`clock_out` AS TIME))) / 60 AS signed)
                   ,0)
                   AS `leave_minutes`,

                IF(CAST(`attendance_view`.`clock_in` AS TIME) IS NULL,1,0) AS `no_attend`,

                IF(CAST(`attendance_view`.`clock_out` AS TIME) IS NULL,1,0) AS `no_leave`,

                IF(TIMEDIFF(`off_duty_time` ,CAST(`attendance_view`.`clock_out` AS TIME)) > 0
                    OR attendance_view.clock_out IS Null,'',TIMEDIFF(`timetables`.`off_duty_time`,  CAST(`attendance_view`.`clock_out` AS TIME))
                    )AS `time_overtime`,
                IF(`attendance_view`.`clock_out` IS NOT NULL ,
                        CAST(TIME_TO_SEC(TIMEDIFF(CAST(`attendance_view`.`clock_out` AS TIME),`timetables`.`off_duty_time`)) / 60 AS signed),0) AS `overtime`
                FROM timetables
                INNER JOIN attendance_view  ON attendance_view.timetable_id = timetables.id"
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_attendance_sheet');
    }
}
