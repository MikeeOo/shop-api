<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
	public function index(): JsonResponse
	{
		$products = Product::paginate(10);

		return $this->ok(new ProductCollection($products)); // 200
	}

	public function store(StoreProductRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$product = Product::create($validated);

		return $this->created(new ProductResource($product)); // 201
	}

	public function show(Product $product): JsonResponse
	{
		return $this->ok(new ProductResource($product)); // 200
	}

	public function update(UpdateProductRequest $request, Product $product): JsonResponse
	{
		$validated = $request->validated();

		$product->update($validated);

		return $this->ok(new ProductResource($product)); // 200
	}

	public function destroy(Product $product): JsonResponse
	{
		$product->delete();

		return $this->noContent(); // 204
	}
}
