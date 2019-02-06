<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Action extends BaseModel
{
	protected $fillable = [
		'name', 'description'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() : BelongsToMany
	{
		return $this->belongsToMany(Role::class, 'role_actions');
	}
}
