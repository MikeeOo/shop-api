<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CamelCaseConverter
{
	public function handle(Request $request, Closure $next): Response
	{
		// Convert camelCase to snake_case for incoming requests
		if ($request->isJson()) {
			$data = $request->all();
			$request->replace($this->camelToSnake($data));
		}

		$response = $next($request);

		// For API responses, convert snake_case to camelCase
		if ($response instanceof \Illuminate\Http\JsonResponse) {
			$content = $response->getData(true);
			$response->setData($this->snakeToCamel($content));
		}

		return $response;
	}

	private function camelToSnake(array $data): array
	{
		$result = [];
		foreach ($data as $key => $value) {
			$snakeKey = Str::snake($key);
			$result[$snakeKey] = is_array($value) ? $this->camelToSnake($value) : $value;
		}
		return $result;
	}

	private function snakeToCamel(array $data): array
	{
		$result = [];
		foreach ($data as $key => $value) {
			$camelKey = Str::camel($key);
			$result[$camelKey] = is_array($value) ? $this->snakeToCamel($value) : $value;
		}
		return $result;
	}
}
