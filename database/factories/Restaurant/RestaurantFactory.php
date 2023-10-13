<?php

namespace Database\Factories\Restaurant;

use App\Models\Restaurant\Category\RestaurantCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = RestaurantCategory::get()->pluck('id')->toArray();
        $category = $categories[array_rand($categories)];
        return [
            'title' => fake()->word(),
            'category_id' => $category,
            'price' => fake()->regexify('[0-9]{3}'),
            'description' => fake()->sentence(),
            'is_active' => 1,
        ];
    }
}
