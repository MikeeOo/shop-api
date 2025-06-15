<?php

namespace App\JsonApi\V1\Products;

use App\Models\Product;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class ProductSchema extends Schema
{
	/**
	 * The model the schema corresponds to.
	 *
	 * @var string
	 */
	public static string $model = Product::class;

	/**
	 * Get the resource fields.
	 *
	 * @return array
	 */
	public function fields(): array
	{
		return [
			ID::make(),
			Str::make('name')->sortable(),
			Str::make('imageUrl'),
			Str::make('brand')->sortable(),
			Str::make('category')->sortable(),
			Str::make('description'),
			Number::make('stockQuantity')->sortable(),
			Number::make('price')->sortable(),
			DateTime::make('createdAt')->sortable()->readOnly(),
			DateTime::make('updatedAt')->sortable()->readOnly(),
		];
	}

	/**
	 * Get the resource filters.
	 *
	 * @return array
	 */
	public function filters(): array
	{
		return [WhereIdIn::make($this)];
	}

	/**
	 * Get the resource paginator.
	 *
	 * @return Paginator|null
	 */
	public function pagination(): ?Paginator
	{
		return PagePagination::make();
	}
}
