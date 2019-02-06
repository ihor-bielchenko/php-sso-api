<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateData extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'string|max:255',
			'email' => 'email|max:255',
			'password' => 'string|max:255',
			'first_name' => 'string|max:255',
			'last_name' => 'string|max:255',
			'birth_date' => 'date|date_format:Y-m-d H:i:s',
			'avatar' => 'string',
			'roles' => 'string'
		];
	}
}
