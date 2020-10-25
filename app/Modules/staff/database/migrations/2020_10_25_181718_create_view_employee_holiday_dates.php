<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewEmployeeHolidayDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW employee_holiday_dates
            AS
            SELECT employees.attendance_id,holiday_days.date_holiday
            FROM holiday_days
            INNER JOIN employee_holidays ON holiday_days.holiday_id = employee_holidays.holiday_id
            INNER JOIN employees ON employee_holidays.employee_id = employees.id"
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_employee_holiday_dates');
    }
}
