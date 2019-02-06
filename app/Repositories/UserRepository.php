<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use App\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends Repository
{
	/**
	 * @var App\JWT\JWT
	 */
	protected $jwt;

	/**
	 * Provides user model and JWT
	 * @param App\Models\User $user
	 */
	public function __construct(User $user)
	{
		$this->model = $user;
		$this->jwt = new JWT;
	}

	/**
	 * Get user
	 * @param int $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function show(int $id) : Model
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Create a new user
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function create(array $data) : Model
	{
		$user = parent::create($data);

		$val = (Setting::select('value')->where('name', 'multi_roles')->firstOrFail())->toArray();

		// try to bind with roles
		if (isset($data['roles'])) {
			if ($data['roles'] === '[]') {
				$user->roles()->sync([]);
			}
			else if ($roleIDs = json_decode($data['roles'], true)) {
				// if setting multi_roles is true
				if ($val['value'] == true) {
					// attach all roles
					$user->roles()->attach($roleIDs);
				} else {
					// attach only first role from array
					$user->roles()->attach($roleIDs[0]);
				}	
			}
		}

		return $this->show($user->id);
	}

	/**
	 * Update user
	 * @param array $data
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function update(array $data, int $id) : Model
	{
		// update user
		$user = parent::update($data, $id);

		$val = (Setting::select('value')->where('name', 'multi_roles')->firstOrFail())->toArray();

		// try to bind with roles
		if (isset($data['roles'])) {
			if ($data['roles'] === '[]') {
				$user->roles()->sync([]);
			}
			else if ($roleIDs = json_decode($data['roles'], true)) {
				// if setting multi_roles is true
				if ($val['value'] == true) {
					// attach all roles
					$user->roles()->attach($roleIDs);
				} else {
					// attach only first role from array
					$user->roles()->attach($roleIDs[0]);
				}	
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

	/**
	 * Creating new user and to auth
	 * @param array $data
	 * @return array - generated tokens
	 */
	public function createAndAuth(array $data = []) : array
	{
		$user = $this->model->create($data);
		$user->roles()->attach(Role::select('id')->where('name', 'member')->firstOrFail()->id);

		return $this->jwt->auth($user, $data['password']);
	}

	/**
	 * Login user
	 * @param string $email
	 * @param string $password
	 * @return array
	 */
	public function login(string $email = '', string $password = '') : array
	{
		return $this->jwt->auth(
			$this
				->model
				->with(['roles' => function($q) {
					$q->select('name');
				}])
				->where('email', $email)
				->firstOrFail(), 
			$password
		);
	}

	/**
	 * Trying to logout user
	 * @param array $data
	 * @return boolean
	 */
	public function logout(array $data = [])
	{
		return $this
			->findByQuery($data)
			->firstOrFail()
			->clearRefreshToken();
	}

	/**
	 * Generate tokens
	 * @return array
	 */
	public function generateTokens() : array
	{
		return $this->jwt->generateTokens($this->model);
	}

	/**
	 * Trying to recovery user access
	 * @param string $email
	 * @return boolean
	 */
	public function recovery(string $email = '')
	{
		return true;
	}
}