<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			// "sometimes": If a request includes the 'name' field, it must be a string with max 255 characters.
			// If a request doesn't include 'name' at all, that's valid and the existing value will remain unchanged.
			'name' => ['sometimes', 'string', 'max:255'],
			'image_url' => ['nullable', 'url', 'max:2048'],
			'brand' => ['sometimes', 'string', 'max:255'],
			'category' => ['sometimes', 'string', 'max:255'],
			'description' => ['nullable', 'string'],
			'stock_quantity' => ['sometimes', 'integer', 'min:0'],
			'price' => ['sometimes', 'numeric', 'between:0,999999.99'],
			// 'rating' => ['nullable', 'numeric', 'between:0,5.0'], // LATER
			// 'reviews_count' => ['nullable', 'integer', 'min:0'], // LATER
		];
	}

	// Additional validation rules
	public function withValidator($validator)
	{
		// Check if another product already exists with the same name and brand combination,
		// excluding the current product being updated
		$validator->after(function ($validator) {
			if ($this->has('name') && $this->has('brand')) {
				$exists = Product::where('name', $this->name)
					->where('brand', $this->brand)
					->where('id', '!=', $this->route('product')->id)
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