<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => 'BKU-' . fake()->unique()->numberBetween(10000, 99999),
            'price' => fake()->numberBetween(20000, 100000),
            'stock' => fake()->numberBetween(1, 50),
        ];
    }
}
