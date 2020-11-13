<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewEmployeePayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->statement(
            "CREATE OR REPLACE VIEW employee_payroll_view
            AS
            select payroll_components.employee_id, value,code,payroll_components.period,payroll_components.from_date,payroll_components.to_date,
            payroll_sheets.id,payroll_components.total_employees,ar_sheet_name,en_sheet_name,admins.username
            from payroll_components
            inner join payroll_sheets on payroll_components.payroll_sheet_id = payroll_sheets.id
            inner join admins on payroll_components.admin_id = admins.id
            where payroll_components.calculate = 'net'"
          );
          DB::connection('mysql2')->statement(
            "CREATE OR REPLACE VIEW employee_payroll_view
            AS
            select payroll_components.employee_id, value,code,payroll_components.period,payroll_components.from_date,payroll_components.to_date,
            payroll_sheets.id,payroll_components.total_employees,ar_sheet_name,en_sheet_name,admins.username
            from payroll_components
            inner join payroll_sheets on payroll_components.payroll_sheet_id = payroll_sheets.id
            inner join admins on payroll_components.admin_id = admins.id
            where payroll_components.calculate = 'net'"
          );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_employee_payroll');
    }
}
