<?php

use Illuminate\Http\Request;

use App\Http\Middleware\CheckRegisterUserData;
use App\Http\Middleware\CheckHasJWTAccessToken;
use App\Http\Middleware\CheckHasJWTRefreshToken;
use App\Http\Middleware\CheckJWTAccessToken;
use App\Http\Middleware\CheckJWTRefreshToken;

use App\Http\Middleware\RoleGetModel;
use App\Http\Middleware\RoleGetCollection;
use App\Http\Middleware\RoleCreateModel;
use App\Http\Middleware\RoleUpdateModel;
use App\Http\Middleware\RoleDeleteModel;

use App\Http\Middleware\ActionGetModel;
use App\Http\Middleware\ActionGetCollection;
use App\Http\Middleware\ActionCreateModel;
use App\Http\Middleware\ActionUpdateModel;
use App\Http\Middleware\ActionDeleteModel;

use App\Http\Middleware\UserGetModel;
use App\Http\Middleware\UserGetCollection;
use App\Http\Middleware\UserCreateModel;
use App\Http\Middleware\UserUpdateModel;
use App\Http\Middleware\UserDeleteModel;

use App\Http\Middleware\SettingGetModel;
use App\Http\Middleware\SettingGetCollection;
use App\Http\Middleware\SettingCreateModel;
use App\Http\Middleware\SettingUpdateModel;
use App\Http\Middleware\SettingDeleteModel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// create new user and return tokens
Route::post('/register', 'AuthController@register')
	->middleware(CheckRegisterUserData::class);

// get tokens by user data
Route::get('/login', 'AuthController@login');

// delete refresh token
Route::delete('/logout', 'AuthController@logout')
	->middleware(CheckHasJWTRefreshToken::class);

// recovery password
Route::post('/recovery', 'AuthController@recovery');

// update access_token by refresh_token
Route::post('/refresh', 'AuthController@refresh')
	->middleware(
		CheckHasJWTAccessToken::class,
		CheckHasJWTRefreshToken::class,
		CheckJWTRefreshToken::class
	);

Route::middleware([
	CheckHasJWTAccessToken::class,
	CheckJWTAccessToken::class
])->group(function() {

	// manage roles
	Route::prefix('/roles')
		->group(function() {
			Route::get('/{id}', 'RoleController@show')->middleware(RoleGetModel::class);
			Route::get('/', 'RoleController@all')->middleware(RoleGetCollection::class);
			Route::post('/', 'RoleController@create')->middleware(RoleCreateModel::class);
			Route::patch('/{id}', 'RoleController@update')->middleware(RoleUpdateModel::class);
			Route::delete('/{id}', 'RoleController@delete')->middleware(RoleDeleteModel::class);
		});

	// manage users
	Route::prefix('/users')
		->group(function() {
			Route::get('/{id}', 'UserController@show')->middleware(UserGetModel::class);
			Route::get('/', 'UserController@all')->middleware(UserGetCollection::class);
			Route::post('/', 'UserController@create')->middleware(UserCreateModel::class);
			Route::patch('/{id}', 'UserController@update')->middleware(UserUpdateModel::class);
			Route::delete('/{id}', 'UserController@delete')->middleware(UserDeleteModel::class);
		});

	// manage actions
	Route::prefix('/actions')
		->group(function() {
			Route::get('/{id}', 'ActionController@show')->middleware(ActionGetModel::class);
			Route::get('/', 'ActionController@all')->middleware(ActionGetCollection::class);
			Route::post('/', 'ActionController@create')->middleware(ActionCreateModel::class);
			Route::patch('/{id}', 'ActionController@update')->middleware(ActionUpdateModel::class);
			Route::delete('/{id}', 'ActionController@delete')->middleware(ActionDeleteModel::class);
		});

	// manage settings
	Route::prefix('/settings')
		->group(function() {
			Route::get('/{id}', 'SettingController@show')->middleware(SettingGetModel::class);
			Route::get('/', 'SettingController@all')->middleware(SettingGetCollection::class);
			Route::post('/', 'SettingController@create')->middleware(SettingCreateModel::class);
			Route::patch('/{id}', 'SettingController@update')->middleware(SettingUpdateModel::class);
			Route::delete('/{id}', 'SettingController@delete')->middleware(SettingDeleteModel::class);
		});
});