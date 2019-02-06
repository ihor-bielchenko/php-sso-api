<?php

use Illuminate\Database\Seeder;
use App\Models\Action;

class ActionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Action::create([
			'name' => 'RoleGetModel',
			'description' => 'Show role model'
		]);

		Action::create([
			'name' => 'RoleGetCollection',
			'description' => 'Show role collection'
		]);

		Action::create([
			'name' => 'RoleCreateModel',
			'description' => 'Create role model'
		]);

		Action::create([
			'name' => 'RoleUpdateModel',
			'description' => 'Update role model'
		]);

		Action::create([
			'name' => 'RoleDeleteModel',
			'description' => 'Delete role model'
		]);

		Action::create([
			'name' => 'ActionGetModel',
			'description' => 'Get action model'
		]);

		Action::create([
			'name' => 'ActionGetCollection',
			'description' => 'Get action collection'
		]);

		Action::create([
			'name' => 'ActionCreateModel',
			'description' => 'Create action model'
		]);

		Action::create([
			'name' => 'ActionUpdateModel',
			'description' => 'Update action model'
		]);

		Action::create([
			'name' => 'ActionDeleteModel',
			'description' => 'Delete action model'
		]);

		Action::create([
			'name' => 'UserGetModel',
			'description' => 'Get user model'
		]);

		Action::create([
			'name' => 'UserGetCollection',
			'description' => 'Get user collection'
		]);

		Action::create([
			'name' => 'UserCreateModel',
			'description' => 'Create user model'
		]);

		Action::create([
			'name' => 'UserUpdateModel',
			'description' => 'Update user model'
		]);

		Action::create([
			'name' => 'UserDeleteModel',
			'description' => 'Delete user model'
		]);

		Action::create([
			'name' => 'SettingGetModel',
			'description' => 'Get setting model'
		]);

		Action::create([
			'name' => 'SettingGetCollection',
			'description' => 'Get setting collection'
		]);

		Action::create([
			'name' => 'SettingCreateModel',
			'description' => 'Create setting model'
		]);

		Action::create([
			'name' => 'SettingUpdateModel',
			'description' => 'Update setting model'
		]);

		Action::create([
			'name' => 'SettingDeleteModel',
			'description' => 'Delete setting model'
		]);
	}
}
