<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;

// WEB ROUTES
// Catch-all route for the React app | (API routes loaded 1st) => (this loaded 2nd) | MUST be the LAST route
Route::get('/{path?}', [SpaController::class, 'index'])->where('path', '^(?!api).*$');
