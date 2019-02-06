<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends BaseModel
{
	protected $fillable = [ 
		'name', 'description'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function actions() : BelongsToMany
	{
		return $this->belongsToMany(Action::class, 'role_actions', 'role_id', 'action_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() : BelongsToMany
	{
		return $this->belongsToMany(User::class, 'user_roles');
	}
}
