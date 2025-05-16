<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();

			$table->string('sku')->unique(); // Stock Keeping Unit | format: {BRAND}-{CATEGORY}-{SEQUENCE}
			$table->string('name');
			$table->string('image_url', 2048)->nullable(); // VARCHAR(2048) | maximum length for URLs | default: VARCHAR(255)
			$table->string('brand');
			$table->string('category');
			$table->longText('description')->nullable();
			$table->unsignedInteger('stock_quantity')->default(0);
			$table->decimal('price', 8, 2)->unsigned();
			// $table->decimal('rating', 2, 1)->unsigned()->default(0); // LATER
			// $table->unsignedInteger('reviews_count')->default(0); // LATER

			$table->unique(['name', 'brand']); // name and brand together must be unique | additional constraint
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('products');
	}
};