<?php

namespace App\Http\Middleware;

use Closure;
use App\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\Resources\UserUnauthorized;

class CheckJWTAccessToken
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		$explode = explode('.', $request->input('access_token'));
		$payload = json_decode(base64_decode($explode[1]), true);

		$jwt = new JWT;
		$signature = $jwt->createSignature(
			trim($explode[0] .'.'. $explode[1]), 
			env('JWT_SECRET_ACCESS_KEY')
		);

		// check token
		if ($signature !== $explode[2]) {
			return (new UserUnauthorized(null))
				->response()
				->setStatusCode(401);
		}

		// check token expire
		if ($jwt->iatDefine() - $payload['exp'] > $payload['iat']) {
			return (new UserUnauthorized(null))
				->response()
				->setStatusCode(401);
		}

		try {
			for ($i = 0; $i < count($payload['roles']); $i ++) {
				$roles_arr[] = $payload['roles'][$i]['pivot']['role_id'];
			}

			return $next($request->merge([ 'role_id' => $roles_arr ]));
		}
		catch (\Exception $err) {
			return $next($request);
		}
	}
}
