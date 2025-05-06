<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// "app/Providers/RouteServiceProvider.php"
// Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

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
