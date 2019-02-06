<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersCreateData extends FormRequest
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
			'name' => 'required|string|unique:users|max:255',
			'email' => 'required|email|unique:users|max:255',
			'password' => 'required|string|max:255',
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'birth_date' => 'date|date_format:Y-m-d H:i:s',
			'avatar' => 'string',
			'roles' => 'string'
		];
	}
}
