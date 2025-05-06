<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;

// "app/Providers/RouteServiceProvider.php"
// Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

// api test route
Route::get('/', function () {
	return response()->json([
		'message' => 'API works!',
	]);
});

// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});
