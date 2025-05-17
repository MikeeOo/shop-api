<?php
// const HTTP_CREATED = 201;
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
	// 	use HttpResponses;

	public function register(RegisterRequest $request)
	{
		$validated = $request->validated();

		$user = User::create([
			'first_name' => $validated['first_name'],
			'last_name' => $validated['last_name'],
			'email' => $validated['email'],
			'password' => bcrypt($validated['password']),
		]);

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json(
			[
				'user' => $user,
				'token' => $token,
			],
			Response::HTTP_CREATED
		);
		// return $this->success([]);
	}

	public function login(LoginRequest $request)
	{
		$credentials = $request->validated();

		// attempt === failed
		if (!Auth::attempt($credentials)) {
			throw ValidationException::withMessages([
				'email' => ['The provided credentials are incorrect.'],
			]);
			// return $this->error('', 'Credentials do not match', 401);
			// return $this->error('', 'Provided email or password is incorrect', 422);
			// return $this->error('', 'Invalid credentials', 401);
		}

		// $user = Auth::user();
		$user = User::where('email', $credentials['email'])->first();
		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json([
			'user' => $user,
			'token' => $token,
		]);
	}

	public function logout(Request $request)
	{
		// Revoke the token that was used to authenticate the current request
		$request->user()->currentAccessToken()->delete();

		return response()->json([
			'message' => 'Successfully logged out',
		]);
		// 204 No Content
		//		return $this->success(null, 'User logged out successfully', 200);
	}
}
