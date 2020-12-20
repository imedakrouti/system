<?php

use Illuminate\Database\Seeder;

class WeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('weeks')->insert(['week_name'=>'Week 1']);
        \DB::table('weeks')->insert(['week_name'=>'Week 2']);
        \DB::table('weeks')->insert(['week_name'=>'Week 3']);
        \DB::table('weeks')->insert(['week_name'=>'Week 4']);
    }
}
