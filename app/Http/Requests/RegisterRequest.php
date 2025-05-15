<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
			'first_name' => [
				'required',
				'string',
				// 'min:1', // for single-character names in certain cultures // REDUNDANT: if you have 'required' // alternative: 'min:2'
				'max:255', // little storage penalty for VARCHAR // alternatives: 'max:30', 'max:35', 'max:50', 'max:55', 'max:64',
			],
			'last_name' => ['required', 'string', 'max:255'],
			'email' => [
				'required',
				'string',
				'email',
				'unique:users', // "unique:table,column,except,idColumn," if (column === email): no need for specification
				'max:255',
			],
			'password' => [
				'required',
				'confirmed', // looks for 'password_confirmation' name on FRONTEND's INPUT
				Password::defaults(), // laravel default password rules (includes Have I Been Pwned API)
				// Password::min(12)->letters()->numbers()->symbols()->mixedCase()->uncompromised();
			],
		];
	}
}
