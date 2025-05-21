<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use App\Constants\JsonApiConstants as API;
use App\Constants\HttpMethodConstants as HTTP;

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
			!$request->hasHeader(API::ACCEPT) ||
			!$this->hasJsonApiMediaType($request->header(API::ACCEPT))
		) {
			return $this->notAcceptable(
				'API requires ' . API::ACCEPT . ' header with ' . API::MEDIA_TYPE
			); // 406
		}

		// Check Content-Type header for requests with content
		if (
			$request->isMethod(HTTP::POST) ||
			$request->isMethod(HTTP::PATCH) ||
			$request->isMethod(HTTP::PUT)
		) {
			if (
				!$request->hasHeader(API::CONTENT_TYPE) ||
				!$this->hasJsonApiMediaType($request->header(API::CONTENT_TYPE))
			) {
				return $this->unsupportedMediaType(
					'API requires ' . API::CONTENT_TYPE . ' header with ' . API::MEDIA_TYPE
				); // 415
			}
		}
		// Configure response
		$response = $next($request);
		$response->headers->set(API::CONTENT_TYPE, API::MEDIA_TYPE);

		return $response;
	}

	// PRIVATE
	private function hasJsonApiMediaType(string $header): bool
	{
		// if($header) === "application/vnd.api+json"
		$contentTypes = explode(',', $header);
		foreach ($contentTypes as $contentType) {
			if (trim($contentType) === API::MEDIA_TYPE) {
				return true;
			}
		}
		return false;
	}
}
