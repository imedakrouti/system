<?php

use Illuminate\Database\Seeder;
use Student\Models\Students\ReportContent;

class ReportContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportContent::create([
            'endorsement' => '',            
            'admin_id'       => 1
        ]);
    }
}
