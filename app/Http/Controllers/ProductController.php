<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
	// Return all products.
	// IGNORE FOR NOW
	public function index()
	{
		return 'All products';
	}

	// Store new product in DB.
	public function store(Request $request)
	{
		return 'Create new product';
	}

	// Return single product.
	// ISSUE: Product $product is not found - returns 404 error-web-page.
	public function show(Product $product)
	{
		return new ProductResource($product);
	}

	// Update product in DB.
	public function update(Request $request, Product $product)
	{
		return 'Update product';
	}

	// Destroy specified product.
	public function destroy(Product $product)
	{
		return 'Destroy product';
	}
}
