<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Repository implements RepositoryInterface
{
	/**
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;

	/**
	 * Provides model
	 * @param Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * Trying to build query
	 * @param array $query
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function findByQuery(array $query = []) : Builder
	{
		$this->model = $this->model::where(array_keys($query)[0], array_shift($query));

		foreach ($query as $column => $value) {
			$this->model = $this->model->where($column, $value);
		}
		return $this->model;
	}

	/** 
	 * Show the record with the given id
	 * @param int $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function show(int $id) : Model
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Get all instances of model
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

	/**
	 * Create a new record in the database
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function create(array $data) : Model
	{
		return $this->model->create($data);
	}

	/**
	 * Update record in the database
	 * @param array $data
	 * @param int $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function update(array $data, int $id) : Model
	{
		$this->model = $this->show($id);
		$this->model->update($data);

		return $this->model;
	}

	/**
	 * Remove record from the database
	 * @param int $id
	 * @return bool
	 */
	public function delete(int $id)
	{
		return $this->model->destroy($id);
	}

	/**
	 * Get the associated model
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function getModel() : Model
	{
		return $this->model;
	}

	/**
	 * Set the associated model
	 * @param Illuminate\Database\Eloquent\Model
	 * @return App\Repositories\Repository
	 */
	public function setModel(Model $model) : Repository
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * Eager load database relationships
	 */
	public function with($relations)
	{
		return $this->model->with($relations);
	}
}