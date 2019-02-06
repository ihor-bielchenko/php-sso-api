<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Requests\UsersDataQuery;
use App\Http\Requests\UsersCreateData;
use App\Http\Requests\UsersUpdateData;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserItem;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UserManageSuccess;
use App\Http\Resources\UserManageFailure;
use App\Http\Resources\UserDeleteSuccess;

class UserController extends Controller
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
	 * Show the user with the given id
	 * @param int $id
	 * @return App\Http\Resources\UserItem
	 */
	public function show(int $id) : UserItem
	{
		return new UserItem($this->repository->show($id));
	}

	/**
	 * Get users collections
	 * @param App\Http\Requests\UsersDataQuery
	 * @return App\Http\Resources\UsersDataQuery
	 */
	public function all(UsersDataQuery $request) : UsersCollection
	{
		return new UsersCollection($this->repository->all(
			$request->input('query'), 
			$request->input('limit')
		));
	}

	/**
	 * Create the user model
	 * @param App\Http\Requests\UsersCreateData
	 * @return Illuminate\Http\JsonResponse
	 */
	public function create(UsersCreateData $request) : JsonResponse
	{
		if (!$data = $this->repository->create($request->only(
			'name', 
			'first_name',
			'last_name',
			'birth_date',
			'avatar',
			'email',
			'password',
			'roles'
		))) {
			return (new UserManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new UserManageSuccess($data))->response();
	}

	/**
	 * Update the user model
	 * @param App\Http\Requests\UsersUpdateData
	 * @param int $id
	 * @return Illuminate\Http\JsonResponse
	 */
	public function update(UsersUpdateData $request, int $id) : JsonResponse
	{
		if (!$user = $this->repository->update($request->only(
			'name', 
			'first_name',
			'last_name',
			'birth_date',
			'avatar',
			'email',
			'password',
			'roles'
		), $id)) {
			return (new UserManageFailure(null))
				->response()
				->setStatusCode(422);
		}

		return (new UserManageSuccess($user))->response();
	}

	/**
	 * Delete the user model from data base
	 * @param int $id
	 * @return App\Http\Resources\UserDeleteSuccess
	 */
	public function delete(int $id) : UserDeleteSuccess
	{
		return new UserDeleteSuccess($this->repository->delete($id));
	}
}
