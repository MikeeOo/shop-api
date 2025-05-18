<?php

use Illuminate\Support\Facades\Route;

// WEB ROUTES

Route::get('/web', fn() => 'Web works!');

// Catch-all route for the React app
// First, API routes are loaded, then this one
// This MUST be the LAST route defined
Route::get('/{path?}', function () {
	return file_get_contents(public_path('dist/index.html')); // "index.html" doesn't exist == API routes blocked!
})->where('path', '^(?!api).*$');
