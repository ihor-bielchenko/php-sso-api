<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8mb4';
			$table->collation = 'utf8mb4_general_ci';

			$table->increments('id');
			
			$table->string('name')
				->index()
				->nullable(false);
			
			$table->string('first_name')
				->index()
				->nullable(true);
			
			$table->string('last_name')
				->index()
				->nullable(true);
			
			$table->timestamp('birth_date')
				->nullable(true);
			
			$table->string('avatar')
				->nullable(true);
			
			$table->string('email')
				->index()
				->unique()
				->nullable(false);
			
			$table->timestamp('email_verified_at')
				->nullable(true);
			
			$table->string('password')
				->nullable(false);
			
			$table->string('refresh_token')
				->nullable(true);
			
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
