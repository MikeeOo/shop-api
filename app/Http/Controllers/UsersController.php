<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
	public function index(): JsonResponse
	{
		$users = User::paginate(10);

		return $this->ok(new UserCollection($users)); // 200
	}

	public function store(StoreUserRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$user = User::create($validated);

		return $this->created(new UserResource($user)); // 201
	}

	public function show(User $user): JsonResponse
	{
		return $this->ok(new UserResource($user)); // 200
	}

	public function update(UpdateUserRequest $request, User $user): JsonResponse
	{
		$validated = $request->validated();

		$user->update($validated);

		return $this->ok(new UserResource($user)); // 200
	}

	public function destroy(User $user): JsonResponse
	{
		$user->delete();

		return $this->noContent(); // 204
	}
}
