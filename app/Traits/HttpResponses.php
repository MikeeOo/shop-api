<?php

namespace App\Traits;

use App\Constants\JsonApiConstants as API;
use App\Constants\ErrorConstants as ERROR;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait HttpResponses
{
	// SUCCESS RESPONSE
	protected function success(int $code = Response::HTTP_OK, mixed $data = null): JsonResponse
	{
		if ($data instanceof JsonResource) {
			return $data->response()->setStatusCode($code);
		}

		return response()->json($data, $code);
	}

	// 200 | OK
	protected function ok(mixed $data): JsonResponse
	{
		return $this->success(Response::HTTP_OK, $data);
	}

	// 201 | Created
	protected function created(mixed $data): JsonResponse
	{
		return $this->success(Response::HTTP_CREATED, $data);
	}

	// 202 | Accepted
	protected function accepted(mixed $data = null): JsonResponse
	{
		return $this->success(Response::HTTP_ACCEPTED, $data);
	}

	// 204 | No Content
	protected function noContent(): JsonResponse
	{
		return $this->success(Response::HTTP_NO_CONTENT, null);
	}

	// 500 | ERROR RESPONSE | Internal Server Error
	protected function error(
		int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
		string $title = ERROR::INTERNAL_SERVER,
		string $detail = '',
		array $meta = []
	): JsonResponse {
		$errorData = [
			'status' => (string) $code,
			// 'source' => ['pointer' => '$pointer'], // pointers are for validation errors
			'title' => $title,
			'detail' => $detail,
		];

		// Add meta information if provided
		if (!empty($meta)) {
			$errorData['meta'] = $meta;
		}

		return response()->json(
			[
				'errors' => [$errorData],
				'jsonapi' => [
					'version' => API::VERSION,
				],
			],
			$code
		);
	}

	// 401 | Unauthorized
	protected function unauthorized(string $detail = '', array $meta = []): JsonResponse
	{
		return $this->error(Response::HTTP_UNAUTHORIZED, ERROR::UNAUTHORIZED, $detail, $meta);
	}

	// 403 | Forbidden
	protected function forbidden(string $detail = '', array $meta = []): JsonResponse
	{
		return $this->error(Response::HTTP_FORBIDDEN, ERROR::FORBIDDEN, $detail, $meta);
	}

	// 404 | Not Found
	protected function notFound(string $detail = '', array $meta = []): JsonResponse
	{
		return $this->error(Response::HTTP_NOT_FOUND, ERROR::NOT_FOUND, $detail, $meta);
	}

	// 406 | Not Acceptable
	protected function notAcceptable(string $detail = '', array $meta = []): JsonResponse
	{
		return $this->error(Response::HTTP_NOT_ACCEPTABLE, ERROR::NOT_ACCEPTABLE, $detail, $meta);
	}

	// 415 | Unsupported Media Type
	protected function unsupportedMediaType(string $detail = '', array $meta = []): JsonResponse
	{
		return $this->error(
			Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
			ERROR::UNSUPPORTED_MEDIA_TYPE,
			$detail,
			$meta
		);
	}

	// 503 | Service Temporarily Unavailable
	protected function serviceUnavailable(string $detail = '', array $meta = []): JsonResponse
	{
		return $this->error(
			Response::HTTP_SERVICE_UNAVAILABLE,
			ERROR::SERVICE_UNAVAILABLE,
			$detail,
			$meta
		);
	}
}

// protected function handleException(
// 	Exception $e,
// 	string $customMessage = 'An error occurred'
// ): JsonResponse {
// 	Log::error($customMessage . ': ' . $e->getMessage());
// 	return $this->error(
// 		[
// 			[
// 				'status' => '500',
// 				'title' => 'Internal Server Error',
// 				'detail' => $customMessage,
// 			],
// 		],
// 		500
// 	);
// }

// // 405 | Method Not Allowed
// protected function methodNotAllowed($title = 'Method Not Allowed', $detail = ''): JsonResponse
// {
// 	return $this->error($title, $detail, Response::HTTP_METHOD_NOT_ALLOWED);
// }

// // 400 | Bad Request
// protected function badRequest($title = 'Bad Request', $detail = ''): JsonResponse
// {
// 	return $this->error($title, $detail, Response::HTTP_BAD_REQUEST);
// }
