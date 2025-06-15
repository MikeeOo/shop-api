<?php

namespace App\JsonApi\V1\Products;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class ProductRequest extends ResourceRequest
{
	/**
	 * Get the validation rules for the resource.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:255'],
			'imageUrl' => ['nullable', 'string', 'max:2048', 'url'],
			'brand' => ['required', 'string', 'max:255'],
			'category' => ['required', 'string', 'max:255'],
			'description' => ['nullable', 'string'],
			'stockQuantity' => ['required', 'integer', 'min:0'],
			'price' => ['required', 'numeric', 'min:0'],
		];
	}
}
