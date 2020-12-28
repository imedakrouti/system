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
        \DB::table('months')->insert(['en_month_name'=>'January','ar_month_name' => 'يناير']);
        \DB::table('months')->insert(['en_month_name'=>'February','ar_month_name' => 'فبراير']);
        \DB::table('months')->insert(['en_month_name'=>'March','ar_month_name' => 'مارس']);
        \DB::table('months')->insert(['en_month_name'=>'April','ar_month_name' => 'ابريل']);
        \DB::table('months')->insert(['en_month_name'=>'May','ar_month_name' => 'مايو']);
        \DB::table('months')->insert(['en_month_name'=>'June','ar_month_name' => 'يونيو']);
        \DB::table('months')->insert(['en_month_name'=>'July','ar_month_name' => 'يوليو']);
        \DB::table('months')->insert(['en_month_name'=>'August','ar_month_name' => 'أغسطس']);
        \DB::table('months')->insert(['en_month_name'=>'September','ar_month_name' => 'سبتمبر']);
        \DB::table('months')->insert(['en_month_name'=>'October','ar_month_name' => 'أكتوبر']);
        \DB::table('months')->insert(['en_month_name'=>'November','ar_month_name' => 'نوفمبر']);
        \DB::table('months')->insert(['en_month_name'=>'December','ar_month_name' => 'ديسمبر']);
    }
}
