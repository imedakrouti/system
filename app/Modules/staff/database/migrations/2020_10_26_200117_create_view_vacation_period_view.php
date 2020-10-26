<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewVacationPeriodView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW vacation_period_view
            AS
            SELECT 
            vacation_periods.*,vacations.approval2
            from vacations
            INNER JOIN vacation_periods ON vacations.employee_id = vacation_periods.employee_id
            AND vacations.id = vacation_periods.vacation_id"
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_vacation_period_view');
    }
}
