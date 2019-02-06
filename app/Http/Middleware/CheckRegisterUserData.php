<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Resources\UserUnauthorized;

class CheckRegisterUserData
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
		if ($request->input('password') === $request->input('confirm_password')) {
			return $next($request);
		}
		return (new UserUnauthorized(null))
			->response()
			->setStatusCode(401);
	}
}
