<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
	// true === request accessible to unauthenticated users
	// false === 401 unauthorized
	public function authorize(): bool
	{
		return false;
	}

	// TODO: unique:users,email,$user->id ??
	// role instead of is_admin ? // what's is_marketing ?
	public function rules(): array
	{
		return [
			'first_name' => ['sometimes', 'string', 'max:255'],
			'last_name' => ['sometimes', 'string', 'max:255'],
			'email' => [
				'sometimes',
				'string',
				'email',
				'unique:users,email,' . $this->user->id, // ASK AI: why this?
				'max:255',
			],
			'password' => ['sometimes', 'confirmed', Password::defaults()],
		];
	}
}
