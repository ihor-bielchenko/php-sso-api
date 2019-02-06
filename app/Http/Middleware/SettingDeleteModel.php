<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleController;
use App\Http\Resources\UserAccessForbidden;

class SettingDeleteModel
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
		if (!RoleController::defineAccessActionByRole(
			$request->input('role_id'), 
			'SettingDeleteModel'
		)) {
			return (new UserAccessForbidden(null))
				->response()
				->setStatusCode(403);
		}

		return $next($request);
	}
}
