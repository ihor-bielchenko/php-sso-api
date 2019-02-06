<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Repositories\ActionRepository;
use App\Http\Requests\ActionsDataQuery;
use App\Http\Requests\ActionsCreateData;
use App\Http\Requests\ActionsUpdateData;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ActionItem;
use App\Http\Resources\ActionsCollection;
use App\Http\Resources\ActionManageSuccess;
use App\Http\Resources\ActionManageFailure;
use App\Http\Resources\ActionDeleteSuccess;

class ActionController extends Controller
{
	/**
	 * @var App\Repositories\ActionRepository
	 */
	protected $repository;

	/**
	 * Provides repository functionality to the current controller
	 * @param App\Models\Action $action
	 * @return void
	 */
	public function __construct(Action $action)
	{
		$this->repository = new ActionRepository($action);
	}

	/** 
	 * Show the role with the given id
	 * @param int $id
	 * @return App\Http\Resources\ActionItem
	 */
	public function show(int $id) : ActionItem
	{
		return new ActionItem($this->repository->show($id));
	}

	/**
	 * Get actions collections
	 * @param App\Http\Requests\ActionsDataQuery
	 * @return App\Http\Resources\ActionsDataQuery
	 */
	public function all(ActionsDataQuery $request) : ActionsCollection
	{
		return new ActionsCollection($this->repository->all(
			$request->input('query'), 
			$request->input('limit')
		));
	}

	/**
	 * Create the action model
	 * @param App\Http\Requests\ActionsCreateData
	 * @return Illuminate\Http\JsonResponse
	 */
	public function create(ActionsCreateData $request) : JsonResponse
	{
		if (!$data = $this->repository->create($request->only( 'name', 'description' ))) {
			return (new ActionManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new ActionManageSuccess($data))->response();
	}

	/**
	 * Update the action model
	 * @param App\Http\Requests\ActionsUpdateData
	 * @param int $id
	 * @return Illuminate\Http\JsonResponse
	 */
	public function update(ActionsUpdateData $request, int $id) : JsonResponse
	{
		if (!$data = $this->repository->update($request->only( 'name', 'description' ), $id)) {
			return (new ActionManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new ActionManageSuccess($data))->response();
	}

	/**
	 * Delete the action model from data base
	 * @param int $id
	 * @return App\Http\Resources\ActionDeleteSuccess
	 */
	public function delete(int $id) : ActionDeleteSuccess
	{
		return new ActionDeleteSuccess($this->repository->delete($id));
	}
}
