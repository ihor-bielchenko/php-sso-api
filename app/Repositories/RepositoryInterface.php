<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
	public function all($query = '{}', $limit = 10) : LengthAwarePaginator;

	public function create(array $data) : Model;

	public function update(array $data, int $id) : Model;

	public function delete(int $id);

	public function show(int $id) : Model;

	public function findByQuery(array $query = []) : Builder;
}