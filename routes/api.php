<?php

use Illuminate\Support\Facades\Route;
use App\Constants\JsonApiConstants as API;
use App\Constants\ControllerActionConstants as ACTION;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;

// API ROUTES

// PUBLIC ROUTES
Route::get('/', fn() => response()->json(['jsonapi' => ['version' => API::VERSION]])); // TODO: create documentation
Route::get('/products', [ProductsController::class, ACTION::INDEX]);

Route::prefix('auth')->group(function () {
	Route::post('/register', [AuthController::class, 'register']);
	Route::post('/login', [AuthController::class, 'login']);
});

// PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {
	Route::post('/auth/logout', [AuthController::class, 'logout']);

	Route::prefix('users')->group(function () {
		Route::get('/', [UsersController::class, ACTION::INDEX]);
		Route::post('/', [UsersController::class, ACTION::STORE]);
		Route::get('/{user}', [UsersController::class, ACTION::SHOW]);
		Route::put('/{user}', [UsersController::class, ACTION::UPDATE]);
		Route::delete('/{user}', [UsersController::class, ACTION::DESTROY]);
	});

	Route::prefix('products')->group(function () {
		Route::post('/', [ProductsController::class, ACTION::STORE]);
		Route::get('/{product}', [ProductsController::class, ACTION::SHOW]);
		Route::put('/{product}', [ProductsController::class, ACTION::UPDATE]);
		Route::delete('/{product}', [ProductsController::class, ACTION::DESTROY]);
	});
});

// // 404 NOT FOUND
// Route::fallback(fn() => response()->json(['jsonapi' => ['version' => JSON_API::VERSION, 'errors' => [['status' => '404', 'title' => 'Not Found']]], 'errors' => [['status' => '404', 'title' => 'Not Found']]], 404));
