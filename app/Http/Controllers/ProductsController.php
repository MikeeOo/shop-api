<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
	// Return all products.
	public function index()
	{
		return Product::all();
	}

	// Store new product in DB.
	public function store(StoreProductRequest $request)
	{
		$validated = $request->validated();

		$product = Product::create($validated);

		return new ProductResource($product);
	}

	// Return single product via route model binding.
	public function show(Product $product): ProductResource
	{
		return new ProductResource($product);
	}

	// Update product in DB.
	public function update(UpdateProductRequest $request, Product $product)
	{
		$validated = $request->validated();

		$product->update($validated);

		return new ProductResource($product);
	}

	// Destroy specified product.
	public function destroy(Product $product)
	{
		$product->delete();

		return response()->noContent();
	}
}