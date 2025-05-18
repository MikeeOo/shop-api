<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
	// true === request accessible to unauthenticated users
	// false === 401 unauthorized
	public function authorize(): bool
	{
		return true;
	}

	// Can be the same as RegisterRequest.php
	// BUT - no need for "is_admin"
	// admin vs user fields to modify
	public function rules(): array
	{
		return [
			'first_name' => ['required', 'string', 'max:255'],
			'last_name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
			'password' => ['required', 'confirmed', Password::defaults()],
		];
	}
}
// 1. No need for 'role' and 'is_marketing'
// 2. No need for 'password_confirmation'
// 3. No need for 'remember'
// 4. No need for 'email_verified_at'
// 5. No need for 'remember_token'
// 6. No need for 'created_at'
// 7. No need for 'updated_at'
// 8. No need for 'deleted_at'
// 9. No need for 'email_verified_at'
