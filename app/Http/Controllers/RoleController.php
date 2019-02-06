<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Http\Requests\RolesDataQuery;
use App\Http\Requests\RolesCreateData;
use App\Http\Requests\RolesUpdateData;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RoleItem;
use App\Http\Resources\RolesCollection;
use App\Http\Resources\RoleManageSuccess;
use App\Http\Resources\RoleManageFailure;
use App\Http\Resources\RoleDeleteSuccess;

class RoleController extends Controller
{
	/**
	 * @var App\Repositories\RoleRepository
	 */
	protected $repository;

	/**
	 * Provides repository functionality to the current controller
	 * @param App\Models\Role $role
	 * @return void
	 */
	public function __construct(Role $role)
	{
		$this->repository = new RoleRepository($role);
	}

	/** 
	 * Show the role with the given id
	 * @param int $id
	 * @return App\Http\Resources\RoleItem
	 */
	public function show(int $id) : RoleItem
	{
		return new RoleItem($this->repository->show($id));
	}

	/**
	 * Get roles collections
	 * @param App\Http\Requests\RolesDataQuery
	 * @return App\Http\Resources\RolesDataQuery
	 */
	public function all(RolesDataQuery $request) : RolesCollection
	{
		return new RolesCollection($this->repository->all(
			$request->input('query'), 
			$request->input('limit')
		));
	}

	/**
	 * Create the role model
	 * @param App\Http\Requests\RolesCreateData
	 * @return Illuminate\Http\JsonResponse
	 */
	public function create(RolesCreateData $request) : JsonResponse
	{
		if (!$data = $this->repository->create($request->only(
			'name', 
			'description', 
			'users',
			'actions'
		))) {
			return (new RoleManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new RoleManageSuccess($data))->response();
	}

	/**
	 * Update the role model
	 * @param App\Http\Requests\RolesUpdateData
	 * @param int $id
	 * @return Illuminate\Http\JsonResponse
	 */
	public function update(RolesUpdateData $request, int $id) : JsonResponse
	{
		if (!$data = $this->repository->update($request->only( 'name', 'description' ), $id)) {
			return (new RoleManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new RoleManageSuccess($data))->response();
	}

	/**
	 * Delete the role model from data base
	 * @param int $id
	 * @return App\Http\Resources\RoleDeleteSuccess
	 */
	public function delete(int $id) : RoleDeleteSuccess
	{
		return new RoleDeleteSuccess($this->repository->delete($id));
	}

	/**
	 * @param int $id
	 * @param string $actionName 
	 * @return bool
	 */
	public static function defineAccessActionByRole($id, string $actionName)
	{
		$k = 0;
		for ($i = 0; $i < count($id); $i++) {
			if (!Role::whereHas('actions', function($q) use($actionName) {
				$q->where('name', $actionName);
			})->find($id[$i])) {
				$k++;
			}
		}

		// if none of roles from array can't make this action
		if ($k >= count($id)) {
			return false;
		}

		// if at least 1 role from array can make this action 
		return true;
	}
}
