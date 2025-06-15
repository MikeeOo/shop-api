<?php

namespace App\JsonApi\V1\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

/**
 * @property Product $resource
 */
class ProductResource extends JsonApiResource
{
	/**
	 * Get the resource's attributes.
	 *
	 * @param Request|null $request
	 * @return iterable
	 */
	public function attributes($request): iterable
	{
		return [
			'name' => $this->resource->name,
			'imageUrl' => $this->resource->image_url,
			'brand' => $this->resource->brand,
			'category' => $this->resource->category,
			'description' => $this->resource->description,
			'stockQuantity' => $this->resource->stock_quantity,
			'price' => $this->resource->price,
			'createdAt' => $this->resource->created_at,
			'updatedAt' => $this->resource->updated_at,
		];
	}

	/**
	 * Get the resource's relationships.
	 *
	 * @param Request|null $request
	 * @return iterable
	 */
	public function relationships($request): iterable
	{
		return [
				// @TODO
			];
	}
}
