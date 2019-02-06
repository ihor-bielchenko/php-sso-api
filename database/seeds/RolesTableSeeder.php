<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Action;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::create([
			'name' => 'admin',
			'description' => 'Full access to models'
			])
				->actions()
				->attach(Action::select('id')
					->get()
					->map((function($item) { return $item->id; }))
					->toArray());

		Role::create([
			'name' => 'manager',
			'description' => 'Access to manage models'
		])
			->actions()
			->attach(Action::select('id')
				->where('name', '!=', 'RoleCreateModel')
				->where('name', '!=', 'RoleDeleteModel')
				->where('name', '!=', 'ActionCreateModel')
				->where('name', '!=', 'ActionDeleteModel')
				->where('name', '!=', 'UserCreateModel')
				->where('name', '!=', 'UserDeleteModel')
				->where('name', '!=', 'SettingCreateModel')
				->where('name', '!=', 'SettingDeleteModel')
				->get()
				->map((function($item) { return $item->id; }))
				->toArray());

		Role::create([
			'name' => 'member',
			'description' => 'Access to view models'
		])
			->actions()
			->attach(Action::select('id')
				->where('name', 'RoleGetModel')
				->orWhere('name', 'RoleGetCollection')
				->orWhere('name', 'ActionGetModel')
				->orWhere('name', 'ActionGetCollection')
				->orWhere('name', 'SettingGetModel')
				->orWhere('name', 'SettingGetCollection')
				->orWhere('name', 'UserGetModel')
				->orWhere('name', 'UserGetCollection')
				->get()
				->map((function($item) { return $item->id; }))
				->toArray());
	}
}
