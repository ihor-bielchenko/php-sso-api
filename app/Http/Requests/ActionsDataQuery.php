<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionsDataQuery extends FormRequest
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
			'query' => 'string|max:255',
			'limit' => 'numeric|min:1|max:100'
		];
	}
}