<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * The current password being used by the factory.
	 */
	protected static ?string $password;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'first_name' => fake()->firstName(),
			'last_name' => fake()->lastName(),
			'email' => fake()->unique()->safeEmail(),
			'email_verified_at' => now(),
			'password' => (static::$password ??= Hash::make('Password@123')),
			'is_admin' => false,
			'remember_token' => Str::random(10),
		];
	}
	public function admin(): static
	{
		return $this->state(
			fn(array $attributes) => [
				'first_name' => 'John',
				'last_name' => 'Doe',
				'email' => 'a@a.com',
				'password' => Hash::make('JohnDoea@a.com123'),
				'is_admin' => true,
			]
		);
	}
	public function user(): static
	{
		return $this->state(
			fn(array $attributes) => [
				'first_name' => 'Jane',
				'last_name' => 'Doe',
				'email' => 'b@b.com',
				'password' => Hash::make('JaneDoeb@b.com123'),
				'is_admin' => false,
			]
		);
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 */
	public function unverified(): static
	{
		return $this->state(
			fn(array $attributes) => [
				'email_verified_at' => null,
			]
		);
	}
}
