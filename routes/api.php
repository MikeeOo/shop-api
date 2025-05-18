<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;

// API ROUTES

// PUBLIC ROUTES
Route::get('/', fn() => response()->json(['jsonapi' => ['version' => '1.0']])); // TODO: create documentation
Route::get('/products', [ProductsController::class, 'index']);

Route::prefix('auth')->group(function () {
	Route::post('/register', [AuthController::class, 'register']);
	Route::post('/login', [AuthController::class, 'login']);
});

// PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {
	Route::post('/auth/logout', [AuthController::class, 'logout']);

	Route::prefix('users')->group(function () {
		Route::get('/', [UsersController::class, 'index']);
		Route::post('/', [UsersController::class, 'store']);
		Route::get('/{user}', [UsersController::class, 'show']);
		Route::put('/{user}', [UsersController::class, 'update']);
		Route::delete('/{user}', [UsersController::class, 'destroy']);
	});

	Route::prefix('products')->group(function () {
		Route::post('/', [ProductsController::class, 'store']);
		Route::get('/{product}', [ProductsController::class, 'show']);
		Route::put('/{product}', [ProductsController::class, 'update']);
		Route::delete('/{product}', [ProductsController::class, 'destroy']);
	});
});
