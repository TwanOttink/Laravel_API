<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('games', 'Api\GameController@getAllGames');
//Route::get('games/{id}', 'Api\GameController@getGame');
//Route::post('games', 'Api\GameController@createGame');
//Route::put('games/{id}', 'Api\GameController@updateGame');
//Route::delete('games/{id}','Api\GameController@deleteGame');

//Route::get('/games', [GameController::class, 'getAllGames']);
//Route::get('/games/{id}', [GameController::class, 'getGame']);
//Route::post('/games', [GameController::class, 'createGame']);
//Route::put('/games/{id}', [GameController::class, 'updateGame']);
//Route::delete('/games/{id}', [GameController::class, 'deleteGame']);

Route::prefix('auth')->group(function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
});
Route::group([
    'middleware' => 'auth:api'
], function () {
    // ingelogde routes
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::get('/games/{id}', [GameController::class, 'getGame']);
    Route::post('/games', [GameController::class, 'createGame']);
    Route::put('/games/{id}', [GameController::class, 'updateGame']);
    Route::delete('/games/{id}', [GameController::class, 'deleteGame']);
});

Route::group([
    'middleware' => ['auth:api', 'role:admin']
], function () {
    // Only admin access
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUser']);
});
