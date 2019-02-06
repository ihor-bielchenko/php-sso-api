<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
        	'name' => 'multi_roles',
        	'description' => 'Binding multiple roles to user',
        	'value' => 0,
        	'namespace_id' => 0
        ]);
    }
}
