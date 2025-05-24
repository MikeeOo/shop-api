<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$user = User::create([
			'first_name' => $validated['first_name'],
			'last_name' => $validated['last_name'],
			'email' => $validated['email'],
			// password is auto-hashed, you hash it for additional security and clarity
			'password' => Hash::make($validated['password']), // bcrypt wrapper = better for future
		]);

		$token = $user->createToken('auth_token')->plainTextToken;

		return $this->created(new UserResource($user, $token)); // 201
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		// if (wrong credentials)
		if (!Auth::attempt($credentials)) {
			throw ValidationException::withMessages([
				'email' => ['The provided credentials are incorrect.'],
			]);
		}

		$user = User::where('email', $credentials['email'])->first();

		$token = $user->createToken('auth_token')->plainTextToken;

		return $this->ok(new UserResource($user, $token)); // 200
	}

	public function logout(Request $request): JsonResponse
	{
		$request->user()->currentAccessToken()->delete(); // Revoke the token used to authenticate CURRENT REQUEST

		return $this->noContent(); // 204
	}
}
