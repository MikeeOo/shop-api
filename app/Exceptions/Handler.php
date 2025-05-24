<?php

namespace App\Exceptions;

use App\Traits\HttpResponses;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Throwable;

class Handler extends ExceptionHandler
{
	use HttpResponses;
	/**
	 * The list of the inputs that are never flashed to the session on validation exceptions.
	 *
	 * @var array<int, string>
	 */
	protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

	/**
	 * Register the exception handling callbacks for the application.
	 */
	public function register(): void
	{
		// $this->reportable(function (Throwable $e) { // default exception handler
		$this->renderable(function (NotFoundHttpException $e, $request) {
			// alternative: $request->wantsJson()
			if ($request->is('api/*')) {
				//
				// Basic implementation:
				// return $this->notFound('The requested resource was not found');
				//
				// Advanced implementation:
				// Extract resource type from URL for more specific error message
				$path = trim($request->getPathInfo(), '/');
				$segments = explode('/', $path);

				// Get the resource type (e.g., 'users', 'products', 'orders')
				$resourceType = isset($segments[1]) ? rtrim($segments[1], 's') : 'resource';

				// Check if it's a specific resource (has ID) or collection
				$isSpecificResource = isset($segments[2]) && is_numeric($segments[2]);

				if ($isSpecificResource) {
					$resourceId = $segments[2];
					$message = "The requested {$resourceType} with ID {$resourceId} was not found";
				} else {
					$message = "The requested {$resourceType} endpoint was not found";
				}

				// path information in meta
				return $this->notFound($message, [
					'requested_path' => $request->getPathInfo(),
					'request_method' => $request->getMethod(),
				]);
			}
		});
	}
}
