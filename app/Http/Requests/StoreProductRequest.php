<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class StoreProductRequest extends FormRequest
{
	// "true" === request accessible to unauthenticated users
	// "false" === 401 unauthorized
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:255'],
			'image_url' => ['nullable', 'url', 'max:2048'], // maximum length for URLs
			'brand' => ['required', 'string', 'max:255'],
			'category' => ['required', 'string', 'max:255'],
			'description' => ['nullable', 'string'],
			'stock_quantity' => ['required', 'integer', 'min:0'], // 0 !== negative number
			'price' => ['required', 'numeric', 'between:0,999999.99'], // 0 -> 999999.99
			// 'rating' => ['nullable', 'numeric', 'between:0,5.0'], // LATER
			// 'reviews_count' => ['nullable', 'integer', 'min:0'], // LATER
		];
	}

	// Additional validation rules
	public function withValidator($validator)
	{
		// Check if another product already exists with the same name and brand combination
		$validator->after(function ($validator) {
			if ($this->name && $this->brand) {
				$exists = Product::where('name', $this->name)
					->where('brand', $this->brand)
					->exists();

				if ($exists) {
					$validator
						->errors()
						->add('name', 'A product with this name and brand already exists.');
				}
			}
		});
	}
}