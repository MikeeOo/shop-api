<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SpaController extends Controller
{
	// Serve the SPA or handle fallback errors
	public function index(Request $request)
	{
		try {
			$indexPath = public_path('dist/index.html');

			// if (index.html not found)
			if (!file_exists($indexPath)) {
				Log::warning('SPA index.html not found', ['path' => $indexPath]);

				// if (API request)
				if ($request->is('api/*') || $request->wantsJson()) {
					return $this->serviceUnavailable(
						'Frontend application is currently unavailable. Please try again in a moment.'
					); // 503
				}

				// (WEB requests) => maintenance page
				return response()->view(
					'maintenance',
					[
						'title' => 'Frontend Unavailable',
						'message' =>
							'We\'re updating the application. Please try again in a moment.',
						'icon' => '🚀',
						'statusCode' => '503',
					],
					503
				);
			}

			// Additional production safety checks
			if (!is_readable($indexPath)) {
				Log::error('SPA index.html not readable', ['path' => $indexPath]);
				throw new Exception('File not readable');
			}

			// Check file size (prevent memory issues)
			$fileSize = filesize($indexPath);
			if ($fileSize === false || $fileSize > 10 * 1024 * 1024) {
				// 10MB limit
				Log::error('SPA index.html invalid size', [
					'path' => $indexPath,
					'size' => $fileSize,
				]);
				throw new Exception('Invalid file size');
			}

			$content = file_get_contents($indexPath);
			if ($content === false) {
				throw new Exception('Failed to read file');
			}

			return response($content)
				->header('Content-Type', 'text/html; charset=utf-8')
				->header('Cache-Control', 'no-cache, no-store, must-revalidate');
			//
		} catch (Exception $e) {
			// Enhanced logging with context
			Log::error('SPA serving error', [
				'error' => $e->getMessage(),
				'path' => $request->path(),
				'user_agent' => $request->userAgent(),
				'ip' => $request->ip(),
				'file' => $indexPath ?? 'unknown',
			]);

			// Use HttpResponses trait for consistent error handling
			if ($request->is('api/*') || $request->wantsJson()) {
				return $this->serviceUnavailable(
					'Unable to serve the application. Please try again in a moment.'
				);
			}

			// For web requests, return user-friendly error
			return response()->view(
				'maintenance',
				[
					'title' => 'Technical Difficulties',
					'message' =>
						'We\'re experiencing technical difficulties. Please try again in a moment.',
					'details' => 'Our team has been notified and is working to resolve this issue.',
					'icon' => '⚠️',
					'statusCode' => '503',
				],
				503
			);
		}
	}
}
