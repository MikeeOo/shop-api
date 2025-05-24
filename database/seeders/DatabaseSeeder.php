<?php

namespace Database\Seeders;

// * use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// Users
		// User::factory()->admin()->create();
		// User::factory()->user()->create();
		User::factory(10)->create();

		// Products
		Product::factory(10)->create();
	}
}
