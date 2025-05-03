<?php

use Illuminate\Support\Facades\Route;

// Web Routes
// Loaded by - "app/Providers/RouteServiceProvider.php"
// All of them will be assigned to the "web" middleware group.

Route::get('/web', function () {
	return 'Web works!';
});

// Catch-all route for the React app
// This must be the LAST route defined
Route::get('/{path?}', function () {
	// Make sure this file exists - it will block API routes otherwise!
	return file_get_contents(public_path('dist/index.html'));
})->where('path', '^(?!api).*$');
