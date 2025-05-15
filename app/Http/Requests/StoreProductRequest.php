<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
	// true === request accessible to unauthenticated users
	// false === 401 unauthorized
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
				//
			];
	}
}
