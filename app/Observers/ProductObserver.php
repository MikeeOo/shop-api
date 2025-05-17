<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
	// Runs BEFORE a product is created.
	public function creating(Product $product): void
	{
		// Auto-generate SKU in format {BRAND}-{CATEGORY}-{SEQUENCE}
		$brand = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $product->brand), 0, 3));
		$category = strtoupper(
			substr(preg_replace('/[^A-Za-z0-9]/', '', $product->category), 0, 3)
		);

		// Find highest sequence for this brand-category
		$latestProduct = Product::where('brand', $product->brand)
			->where('category', $product->category)
			->where('sku', 'LIKE', $brand . '-' . $category . '-%')
			->orderBy('sku', 'desc')
			->first();

		$sequence = 1;
		if ($latestProduct) {
			$parts = explode('-', $latestProduct->sku);
			$sequence = intval(end($parts)) + 1;
		}

		// Format with leading zeros (4 digits)
		$sequenceFormatted = str_pad($sequence, 4, '0', STR_PAD_LEFT);

		// Create final SKU
		$product->sku = "{$brand}-{$category}-{$sequenceFormatted}";
	}

	/**
	 * Handle the Product "created" event.
	 */
	public function created(Product $product): void
	{
		//
	}

	/**
	 * Handle the Product "updated" event.
	 */
	public function updated(Product $product): void
	{
		//
	}

	/**
	 * Handle the Product "deleted" event.
	 */
	public function deleted(Product $product): void
	{
		//
	}

	/**
	 * Handle the Product "restored" event.
	 */
	public function restored(Product $product): void
	{
		//
	}

	/**
	 * Handle the Product "force deleted" event.
	 */
	public function forceDeleted(Product $product): void
	{
		//
	}
}
