<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAttendanceSheetDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW attendance_sheet_dates
            AS
		    SELECT
		       period.attendance_id AS attendance_id,
		       period.`selected_date` AS `selected_date`,
		        `attendance_sheet`.`clock_in` AS `clock_in`,
		        `attendance_sheet`.`clock_out` AS `clock_out`,
		        `attendance_sheet`.`work_time` AS `work_time`,
		        `attendance_sheet`.`lates` AS `lates`,
		        `attendance_sheet`.`minutes` AS `minutes`,
		        `attendance_sheet`.`leave_early` AS `leave_early`,
		        `attendance_sheet`.`leave_minutes` AS `leave_minutes`,
		        `attendance_sheet`.`no_attend` AS `no_attend`,
		        `attendance_sheet`.`no_leave` AS `no_leave`,
		        `attendance_sheet`.`overtime` AS `overtime`
		    FROM `attendance_sheet`
		    LEFT JOIN  period ON		            
		               period.`selected_date` = `attendance_sheet`.`Date` AND period.attendance_id = attendance_sheet.attendance_id
			UNION
		    SELECT
		       period.attendance_id AS attendance_id,
		       period.`selected_date` AS `selected_date`,
			    `attendance_sheet`.`clock_in` AS `clock_in`,
		        `attendance_sheet`.`clock_out` AS `clock_out`,
		        `attendance_sheet`.`work_time` AS `work_time`,
		        `attendance_sheet`.`lates` AS `lates`,
		        `attendance_sheet`.`minutes` AS `minutes`,
		        `attendance_sheet`.`leave_early` AS `leave_early`,
		        `attendance_sheet`.`leave_minutes` AS `leave_minutes`,
		        `attendance_sheet`.`no_attend` AS `no_attend`,
		        `attendance_sheet`.`no_leave` AS `no_leave`,
		        `attendance_sheet`.`overtime` AS `overtime`
		    FROM period
		     LEFT JOIN `attendance_sheet` ON		            
		               period.`selected_date` = `attendance_sheet`.`Date` AND period.attendance_id = attendance_sheet.attendance_id"
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_attendance_sheet_dates');
    }
}
