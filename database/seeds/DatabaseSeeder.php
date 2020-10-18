<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(ReportContentSeeder::class);
        $this->call(HrReportSeeder::class);
        $this->call(DaysSeeder::class);
    }
}
