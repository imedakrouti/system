<?php

use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('months')->insert(['month_name'=>'January']);
        \DB::table('months')->insert(['month_name'=>'February']);
        \DB::table('months')->insert(['month_name'=>'March']);
        \DB::table('months')->insert(['month_name'=>'April']);
        \DB::table('months')->insert(['month_name'=>'May']);
        \DB::table('months')->insert(['month_name'=>'June']);
        \DB::table('months')->insert(['month_name'=>'July']);
        \DB::table('months')->insert(['month_name'=>'August']);
        \DB::table('months')->insert(['month_name'=>'September']);
        \DB::table('months')->insert(['month_name'=>'October']);
        \DB::table('months')->insert(['month_name'=>'November']);
        \DB::table('months')->insert(['month_name'=>'December']);
    }
}
