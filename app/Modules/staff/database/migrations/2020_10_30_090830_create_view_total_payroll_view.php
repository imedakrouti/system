<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewTotalPayrollView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW total_payroll_view
            AS
            SELECT payroll_components.code, payroll_sheets.id AS payroll_sheet_id,
            payroll_components.period , payroll_components.from_date,payroll_components.to_date,
            payroll_sheets.ar_sheet_name,payroll_sheets.en_sheet_name,
            total_employees,
            ( SELECT SUM(value) FROM payroll_components WHERE payroll_components.calculate = 'net' ) AS total_Payroll,
            (SELECT admins.username FROM admins WHERE admins.id = payroll_components.admin_id LIMIT 1) AS username,
                        payroll_components.created_at AS created_at
            FROM payroll_components
            INNER JOIN payroll_sheets ON payroll_components.payroll_sheet_id = payroll_sheets.id
            GROUP BY payroll_sheets.id,payroll_components.period , payroll_components.from_date,payroll_components.to_date,
            payroll_sheets.ar_sheet_name,payroll_sheets.en_sheet_name,total_employees,payroll_components.code,
            payroll_components.created_at,payroll_components.admin_id
            ORDER BY payroll_components.created_at DESC
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
        Schema::dropIfExists('view_total_payroll_view');
    }
}
