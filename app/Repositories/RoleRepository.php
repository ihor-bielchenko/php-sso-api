<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository extends Repository
{
	/**
	 * Get role
	 * @param int $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function show(int $id) : Model
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Create a new role
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function create(array $data) : Model
	{
		$role = parent::create($data);

		// try to bind with actions
		if (isset($data['actions'])) {
			if ($data['actions'] === '[]') {
				$role->actions()->sync([]);
			}

			else if ($actionIDs = json_decode($data['actions'], true)) {
				$role->actions()->attach($actionIDs);
			}
		}

		// try to bind with users
		if (isset($data['users'])) {
			if ($data['users'] === '[]') {
				$role->users()->sync([]);
			}

			else if ($userIDs = json_decode($data['users'], true)) {
				$role->users()->attach($userIDs);
			}
		}

		return $this->show($role->id);
	}

	/**
	 * Update role
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function update(array $data, int $id) : Model
	{
		// update role
		$role = parent::update($data, $id);

		// try to bind with actions
		if (isset($data['actions'])) {
			if ($data['actions'] === '[]') {
				$role->actions()->sync([]);
			}

			else if ($actionIDs = json_decode($data['actions'], true)) {
				$role->actions()->attach($actionIDs);
			}
		}

		// try to bind with users
		if (isset($data['users'])) {
			if ($data['users'] === '[]') {
				$role->users()->sync([]);
			}

			else if ($userIDs = json_decode($data['users'], true)) {
				$role->users()->attach($userIDs);
			}
		}

		return $this->show($id);
	}

	/**
	 * Get all items with pagination
	 * @param string $query
	 * @param int $limit
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function all($query = '{}', $limit = 10) : LengthAwarePaginator
	{
		if ($data = json_decode($query, true)) {
			$this->model = $this->findByQuery($data);
		}

		return $this->model->paginate($limit);
	}
}