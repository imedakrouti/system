<?php
use Illuminate\Support\Str;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'              => 'Amr',
            'username'          => 'admin',
            'email_verified_at' => now(),
            'password'          => 'password', 
            'remember_token'    => Str::random(10),
        ]);
    }
}
