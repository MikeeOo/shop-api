<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider.
| All of them will be assigned to the "api" middleware group.
|
*/

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
