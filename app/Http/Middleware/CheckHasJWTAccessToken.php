<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Resources\NoAccessTokenSpecified;

class CheckHasJWTAccessToken
{
	/**
	 * Get clear token
	 * @param string $header
	 * @return string
	 */
	protected function explodeAuthorizationString(string $header) : string
	{
		$explode = explode('Bearer ', $header);
		return $explode[1] ?: $header;
	}

	/**
	 * Trying to get access token
	 * @param Illuminate\Http\Request $request
	 * @return string|null
	 */
	protected function defineAccessToken(Request $request)
	{
		return $request->headers->has('Authorization') ?
			$this->explodeAuthorizationString($request->header('Authorization')) : 
			$request->input('access_token');
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($accessToken = $this->defineAccessToken($request)) {
			return $next($request->merge([ 'access_token' => $accessToken ]));
		}
		return (new NoAccessTokenSpecified(null))
			->response()
			->setStatusCode(404);
	}
}
