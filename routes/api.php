<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductsController;

// "app/Providers/RouteServiceProvider.php"
// Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
//
// "/controller/model" - for route->model binding
//
// Auth::routes([
//     'login' => true,
//     'logout' => true,
//     'register' => true,
//     'reset' => true,
//     'confirm' => false,
//     'verify' => false,    // Enable email verification routes
// ]);

// api test route
Route::get('/', function () {
	return response()->json([
		'message' => 'API works!',
	]);
});

// Product routes
Route::get('/products', [ProductsController::class, 'index']);
Route::post('/products', [ProductsController::class, 'store']);
Route::get('/products/{product}', [ProductsController::class, 'show']);
Route::put('/products/{product}', [ProductsController::class, 'update']);
Route::delete('/products/{product}', [ProductsController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});
