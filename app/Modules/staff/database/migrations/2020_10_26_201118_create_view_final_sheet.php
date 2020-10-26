<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewFinalSheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW finalSheet
            AS
            SELECT
            final_attendance_sheet.*,
            employee_holiday_dates.date_holiday,
            leave_requests_view.date_leave,leave_requests_view.time_leave,
            IF((absent = 'True' AND employee_holiday_dates.date_holiday IS Not Null) OR (absent = '' AND date_holiday IS Null),'','True') AS 'absent_after_holidays'
            FROM final_attendance_sheet
            LEFT OUTER JOIN employee_holiday_dates ON final_attendance_sheet.attendance_id = employee_holiday_dates.attendance_id
            AND final_attendance_sheet.selected_date = employee_holiday_dates.date_holiday
            LEFT OUTER JOIN leave_requests_view ON final_attendance_sheet.attendance_id = leave_requests_view.attendance_id
            AND final_attendance_sheet.employee_id = leave_requests_view.employee_id
            AND final_attendance_sheet.selected_date = leave_requests_view.date_leave
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
        Schema::dropIfExists('view_final_sheet');
    }
}
