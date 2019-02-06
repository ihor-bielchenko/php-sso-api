<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAccessToken extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'access_token' => $this->resource['access_token'],
			'refresh_token' => $this->resource['refresh_token'],
			'token_type' => 'bearer',
			'expires_in' => env('JWT_ACCESS_TIMEOUT')
		];
	}
}
