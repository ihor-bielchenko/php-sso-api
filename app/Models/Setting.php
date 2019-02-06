<?php

namespace App\Models;

class Setting extends BaseModel
{
	protected $fillable = [
		'name', 'description', 'value', 'namespace_id'
	];
}
