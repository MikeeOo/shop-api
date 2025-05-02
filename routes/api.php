<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});
