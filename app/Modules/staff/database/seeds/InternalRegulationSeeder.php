<?php

use Illuminate\Database\Seeder;
use Staff\Models\Employees\InternalRegulation;

class InternalRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InternalRegulation::create([
            'internal_regulation_text' => '',
            'admin_id' => 1
        ]);
    }
}
