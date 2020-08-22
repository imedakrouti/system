<?php
use Illuminate\Support\Str;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'ar_school_name' => 'مدرستي',
            'en_school_name' => 'My School',
            'admin_id'       => 1
        ]);
    }
}
