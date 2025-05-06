<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// class ProductResource extends BaseResource
class ProductResource extends JsonResource
{
	// Resource -> JSON<array>
	public function toArray(Request $request): array
	{
		// return $this->camelizeKeys([
		return [
			'type' => 'products',
			'id' => (string) $this->id,
			'attributes' => [
				'name' => $this->name,
				'image_url' => $this->image_url,
				'brand' => $this->brand,
				'category' => $this->category,
				'description' => $this->description,
				'stock_quantity' => $this->stock_quantity,
				'price' => $this->price,
				'rating' => $this->rating,
				'reviews_count' => $this->reviews_count,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at,
				// 'created_at' => $this->created_at->toIso8601String(),
				// 'updated_at' => $this->updated_at->toIso8601String(),
			],
			'relationships' => [],
			'links' => [
				'self' => url('/products/' . $this->id), // change to route name later...
				// 'self' => route('products.show', $this->id),
			],
		];
		// ]);
	}
	// adds "meta" outside of "data"
	public function with($request)
	{
		return [
			'included' => [], // relationships
			'links' => [
				'self' => url('/products/' . $this->id), // change to route name later...
				// 'self' => route('products.show', $this->id),
			],
			'meta' => [
				'author' => 'MikeeOo',
				'version' => '1.0.0',
				'snake_case_test' => 'John Doe',
			],
		];
	}
}
