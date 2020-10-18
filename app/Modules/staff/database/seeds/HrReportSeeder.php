<?php

use Illuminate\Database\Seeder;
use Staff\Models\Settings\HrReport;

class HrReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HrReport::create([
            'hr_letter'             => '',            
            'employee_leave'        => '',            
            'employee_experience'   => '',            
            'employee_vacation'     => '',            
            'admin_id'              => 1
        ]);
    }
}
