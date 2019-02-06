<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Resources\UserAccessToken;
use App\Http\Resources\UserUnauthorized;
use App\Http\Resources\UserLogoutSuccess;
use App\Http\Resources\UserRecovery;
use App\Http\Requests\AuthRegisterData;
use App\Http\Requests\AuthLoginData;
use App\Http\Requests\AuthRecoveryData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	/**
	 * @var App\Repositories\UserRepository
	 */
	protected $repository;

	/**
	 * Provides repository functionality to the current controller
	 * @param App\Models\User $user
	 * @return void
	 */
	public function __construct(User $user)
	{
		$this->repository = new UserRepository($user);
	}

	/**
	 * To sign up new user
	 * @param App\Http\Requests\AuthRegisterData
	 * @return App\Http\Resources\UserAccessToken
	 */
	public function register(AuthRegisterData $request)
	{
		return new UserAccessToken($this->repository->createAndAuth($request->only(
			'name', 
			'email', 
			'password', 
			'first_name', 
			'last_name', 
			'avatar', 
			'birth_date'
		)));
	}

	/**
	 * Login user
	 * @param App\Http\Requests\AuthLoginData
	 * @return Illuminate\Http\JsonResponse
	 */
	public function login(AuthLoginData $request) : JsonResponse
	{
		if (!$tokens = $this->repository->login(
			$request->input('email'),
			$request->input('password')
		)) {
			return (new UserUnauthorized(null))
				->response()
				->setStatusCode(401);
		}
		return (new UserAccessToken($tokens))->response();
	}

	/**
	 * Logout user
	 * @param Illuminate\Http\Request $request
	 * @return App\Http\Resources\UserLogoutSuccess
	 */
	public function logout(Request $request) : UserLogoutSuccess
	{
		return new UserLogoutSuccess($this->repository->logout($request->only('refresh_token')));
	}

	/**
	 * To recovery user access
	 * @param App\Http\Requests\AuthRecoveryData;
	 * @return App\Http\Resources\UserRecovery
	 */
	public function recovery(AuthRecoveryData $request) : UserRecovery
	{
		return new UserRecovery($this->repository->recovery($request->input('email')));
	}

	/**
	 * Update tokens
	 * @param Illuminate\Http\Request $request
	 * @return Illuminate\Http\JsonResponse
	 */
	public function refresh(Request $request) : JsonResponse
	{
		if (!$user = $this->repository->findByQuery($request->only('name'))->firstOrFail()) {
			return (new UserUnauthorized(null))
				->response()
				->setStatusCode(401);
		}

		if ($user->refresh_token !== $request->input('refresh_token')) {
			return (new UserUnauthorized(null))
				->response()
				->setStatusCode(401);
		}

		return (new UserAccessToken($this->repository->setModel($user)->generateTokens()))
			->response();
	}
}