<?php

use Illuminate\Database\Seeder;


class DateListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('date_lists')->insert(['selected_date' => '2020-07-01']);
    }
}
