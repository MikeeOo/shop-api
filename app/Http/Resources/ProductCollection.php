<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
	// Transform JSON:API compliant resources into an array.
	public function toArray(Request $request): array
	{
		return [
			'data' => $this->collection,
		];
	}

	// Additional JSON:API compliant metadata.
	public function with($request)
	{
		return [
			'links' => [
				'self' => url()->current(),
			],
			// 'meta' => [
			// 	'author' => 'MikeeOo',
			// 	'version' => '1.0.0',
			// 	'snake_case_test' => 'John Doe',
			// ],
			// 'jsonapi' => [
			// 	'version' => '1.0',
			// ],
			// 'included' => [],
		];
	}
}
