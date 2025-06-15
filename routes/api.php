<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

// Route::get('/user', function (Request $request) {
// 	return $request->user();
// })->middleware('auth:sanctum');

// * JsonApiRoute::server('v1')->prefix('v1')
JsonApiRoute::server('v1')->resources(function ($server) {
	$server->resource('products', ProductController::class);
});
