<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
	public function definition(): array
	{
		return [
			// * 'user_id' => User::all()->random()->id,
			'name' => fake()->words(3, true),
			'image_url' => fake()->imageUrl(),
			// * 'image_url' => fake()->optional()->imageUrl(),
			'brand' => fake()->company(),
			'category' => fake()->word(),
			'description' => fake()->paragraph(),
			'stock_quantity' => fake()->numberBetween(0, 1000),
			'price' => fake()->randomFloat(2, 1, 1000),
			// 'rating' => fake()->randomFloat(1, 0, 5), // LATER
			// 'reviews_count' => fake()->numberBetween(0, 500), // LATER
		];
	}
}
