<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ActionRepository extends Repository
{
	/**
	 * Get action
	 * @param int $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function show(int $id) : Model
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Create a new action
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function create(array $data) : Model
	{
		$action = parent::create($data);

		// try to bind with roles
		if (isset($data['roles'])) {
			if ($data['roles'] === '[]') {
				$action->roles()->sync([]);
			}

			else if ($roleIDs = json_decode($data['roles'], true)) {
				$action->roles()->attach($roleIDs);
			}
		}

		return $this->show($action->id);
	}

	/**
	 * Update action
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function update(array $data, int $id) : Model
	{
		// update action
		$action = parent::update($data, $id);

		// try to bind with roles
		if (isset($data['roles'])) {
			if ($data['roles'] === '[]') {
				$action->roles()->sync([]);
			}

			else if ($roleIDs = json_decode($data['roles'], true)) {
				$action->roles()->attach($roleIDs);
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