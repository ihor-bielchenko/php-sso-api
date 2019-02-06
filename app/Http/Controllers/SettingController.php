<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use App\Http\Requests\SettingsDataQuery;
use App\Http\Requests\SettingsCreateData;
use App\Http\Requests\SettingsUpdateData;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SettingItem;
use App\Http\Resources\SettingsCollection;
use App\Http\Resources\SettingManageSuccess;
use App\Http\Resources\SettingManageFailure;
use App\Http\Resources\SettingDeleteSuccess;

class SettingController extends Controller
{
	/**
	 * @var App\Repositories\SettingRepository
	 */
	protected $repository;

	/**
	 * Provides repository functionality to the current controller
	 * @param App\Models\Setting $setting
	 * @return void
	 */
	public function __construct(Setting $setting)
	{
		$this->repository = new SettingRepository($setting);
	}

	/** 
	 * Show the role with the given id
	 * @param int $id
	 * @return App\Http\Resources\SettingItem
	 */
	public function show(int $id) : SettingItem
	{
		return new SettingItem($this->repository->show($id));
	}

	/**
	 * Get settings collections
	 * @param App\Http\Requests\SettingsDataQuery
	 * @return App\Http\Resources\SettingsDataQuery
	 */
	public function all(SettingsDataQuery $request) : SettingsCollection
	{
		return new SettingsCollection($this->repository->all(
			$request->input('query'), 
			$request->input('limit')
		));
	}

	/**
	 * Create the setting model
	 * @param App\Http\Requests\SettingsCreateData
	 * @return Illuminate\Http\JsonResponse
	 */
	public function create(SettingsCreateData $request) : JsonResponse
	{
		if (!$data = $this->repository->create($request->only(
			'name', 
			'description', 
			'value', 
			'namespace_id'
		))) {
			return (new SettingManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new SettingManageSuccess($data))->response();
	}

	/**
	 * Update the setting model
	 * @param App\Http\Requests\SettingsUpdateData
	 * @param int $id
	 * @return Illuminate\Http\JsonResponse
	 */
	public function update(SettingsUpdateData $request, int $id) : JsonResponse
	{
		if (!$data = $this->repository->update($request->only(
			'name',
			'description', 
			'value', 
			'namespace_id'
		), $id)) {
			return (new SettingManageFailure(null))
				->response()
				->setStatusCode(422);
		}
		return (new SettingManageSuccess($data))->response();
	}

	/**
	 * Delete the setting model from data base
	 * @param int $id
	 * @return App\Http\Resources\SettingDeleteSuccess
	 */
	public function delete(int $id) : SettingDeleteSuccess
	{
		return new SettingDeleteSuccess($this->repository->delete($id));
	}
}
