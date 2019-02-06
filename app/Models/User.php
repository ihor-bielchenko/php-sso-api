<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'first_name', 'last_name', 'birth_date', 'avatar', 'email', 'password', 'refresh_token'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function setPasswordAttribute($password)
	{
		if ( !empty($password) ) {
			$this->attributes['password'] = bcrypt($password);
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() : BelongsToMany
	{
		return $this->belongsToMany(Role::class, 'user_roles')->select([ 'name' ]);
	}

	/**
	 * To delete refresh token from DB
	 * @return boolean
	 */
	public function clearRefreshToken()
	{
		$this->refresh_token = '';
		return $this->save();
	}

	/**
	 * Get user
	 * @param string $name
	 * @return string
	 */
	public static function getByName(string $name) : string
	{
		return User::where('name', $name)->firstOrFail();
	}
}
