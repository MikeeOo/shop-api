<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait HttpResponses
{
	// SUCCESS RESPONSE
	protected function success(mixed $data, int $code = Response::HTTP_OK): JsonResponse
	{
		if ($data instanceof JsonResource) {
			return $data->response()->setStatusCode($code);
		}

		return response()->json($data, $code);
	}

	// 200 | OK
	protected function ok(mixed $data): JsonResponse
	{
		return $this->success($data, Response::HTTP_OK);
	}

	// 201 | Created
	protected function created(mixed $data): JsonResponse
	{
		return $this->success($data, Response::HTTP_CREATED);
	}

	// 204 | No Content
	protected function noContent(): JsonResponse
	{
		return response()->json(null, Response::HTTP_NO_CONTENT);
	}

	// 500 | ERROR RESPONSE | Internal Server Error
	protected function error(
		string $title = 'Internal Server Error',
		string $detail = '',
		int $code = Response::HTTP_INTERNAL_SERVER_ERROR
	): JsonResponse {
		return response()->json(
			[
				'errors' => [
					[
						'status' => (string) $code,
						'source' => ['pointer' => '$pointer'],
						'title' => $title,
						'detail' => $detail,
					],
				],
				'jsonapi' => [
					'version' => '1.0',
				],
			],
			$code
		);
	}

	// 401 | Unauthorized
	protected function unauthorized(string $detail = ''): JsonResponse
	{
		return $this->error('Unauthorized', $detail, Response::HTTP_UNAUTHORIZED);
	}

	// 403 | Forbidden
	protected function forbidden(string $detail = ''): JsonResponse
	{
		return $this->error('Forbidden', $detail, Response::HTTP_FORBIDDEN);
	}

	// 404 | Not Found
	protected function notFound(string $detail = ''): JsonResponse
	{
		return $this->error('Not Found', $detail, Response::HTTP_NOT_FOUND);
	}

	// 406 | Not Acceptable
	protected function notAcceptable(string $detail = ''): JsonResponse
	{
		return $this->error('Not Acceptable', $detail, Response::HTTP_NOT_ACCEPTABLE);
	}

	// 415 | Unsupported Media Type
	protected function unsupportedMediaType(string $detail = ''): JsonResponse
	{
		return $this->error(
			'Unsupported Media Type',
			$detail,
			Response::HTTP_UNSUPPORTED_MEDIA_TYPE
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
