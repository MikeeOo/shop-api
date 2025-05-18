<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonApiMiddleware
{
	use HttpResponses;

	// Handle an incoming request.
	public function handle(Request $request, Closure $next): Response
	{
		// Check Accept header for all requests
		if (
			!$request->hasHeader('Accept') ||
			!$this->hasJsonApiContentType($request->header('Accept'))
		) {
			return $this->notAcceptable('API requires Accept header with application/vnd.api+json'); // 406
		}

		// Check Content-Type header for requests with content
		if (
			$request->isMethod('POST') ||
			$request->isMethod('PATCH') ||
			$request->isMethod('PUT')
		) {
			if (
				!$request->hasHeader('Content-Type') ||
				!$this->hasJsonApiContentType($request->header('Content-Type'))
			) {
				return $this->unsupportedMediaType(
					'API requires Content-Type header with application/vnd.api+json'
				); // 415
			}
		}
		// Configure response
		$response = $next($request);
		$response->headers->set('Content-Type', 'application/vnd.api+json');

		return $response;
	}

	// PRIVATE
	private function hasJsonApiContentType(string $header): bool
	{
		// check: if($header) === "application/vnd.api+json"
		$contentTypes = explode(',', $header);
		foreach ($contentTypes as $contentType) {
			if (trim($contentType) === 'application/vnd.api+json') {
				return true;
			}
		}
		return false;
	}
}
