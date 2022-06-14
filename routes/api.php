<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'user',
], function ($route) {
    $route->post('login', [AuthController::class, 'login']);
    $route->post('register', [AuthController::class, 'register']);
});

Route::group([
    'prefix' => 'user',
    'middleware' => ['auth:api']
], function ($route) {
    $route->post('me', [AuthController::class, 'me']);
    $route->post('logout', [AuthController::class, 'logout']);
});
