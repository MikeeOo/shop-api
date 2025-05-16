<?php

use Illuminate\Support\Facades\Route;

// "app/Providers/RouteServiceProvider.php"
// 1st - "routes/api.php"
// 2nd - Route::middleware('web')->group(base_path('routes/web.php'));

Route::get('/web', function () {
	return 'Web works!';
});

// Catch-all route for the React app
// This must be the LAST route defined
Route::get('/{path?}', function () {
	return file_get_contents(public_path('dist/index.html')); // "index.html" doesn't exist == API routes blocked!
})->where('path', '^(?!api).*$');