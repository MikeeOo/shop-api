<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'string'],
			// 'remember' => ['boolean'],
		];
	}

	public function messages(): array
	{
		return [
			'email.required' => 'Please enter your email address.',
			'email.email' => 'Please enter a valid email address.',
			'password.required' => 'Please enter your password.',
		];
	}
}
// TODO: IMPLEMENT IN CONTROLLER
// return back()->withErrors([
// 'email' => 'The provided credentials do not match our records.',
// ]);
