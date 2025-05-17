<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
	// Return all products.
	public function index(): ProductCollection
	{
		$products = Product::paginate(10);
		return new ProductCollection($products);
	}

	// Store new product in DB.
	public function store(StoreProductRequest $request)
	{
		$validated = $request->validated();

		$product = Product::create($validated);

		return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
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
