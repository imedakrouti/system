<?php

use Illuminate\Database\Seeder;

class DaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('days')->insert(['ar_day'    =>'السبت','en_day'    =>'Saturday','sort'      => 1]);
        \DB::table('days')->insert(['ar_day'    =>'الاحد','en_day'    =>'Sunday','sort'      => 2]);
        \DB::table('days')->insert(['ar_day'    =>'الاثنين','en_day'    =>'Monday','sort'      => 3]);
        \DB::table('days')->insert(['ar_day'    =>'الثلاثاء','en_day'    =>'Tuesday','sort'      => 4]);
        \DB::table('days')->insert(['ar_day'    =>'الاربعاء','en_day'    =>'Wednesday','sort'      => 5]);
        \DB::table('days')->insert(['ar_day'    =>'الخميس','en_day'    =>'Thursday','sort'      => 6]);
        \DB::table('days')->insert(['ar_day'    =>'الجمعه','en_day'    =>'Friday','sort'      => 7]);
    }
}
