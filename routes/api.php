<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// API Routes - prefixed with "/api"
// Loaded by - "app/Providers/RouteServiceProvider.php" | ->prefix('api') |
// All of them will be assigned to the "api" middleware group.

// api test route
Route::get('/', function () {
	return response()->json([
		'message' => 'API works!',
	]);
});

Route::get('/products', function () {
	$products = Product::select('id', 'name', 'brand')->get();
	return response()->json($products);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});
