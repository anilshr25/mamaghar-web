<?php

namespace Database\Factories\Room;

use App\Models\Restaurant\Category\RestaurantCategory;
use App\Models\Room\Category\RoomCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = RoomCategory::get()->pluck('id')->toArray();
        $category = $categories[array_rand($categories)];
        return [
            'title' => fake()->word(),
            'category_id' => $category,
            'room_number' => fake()->regexify('[0-9]{1}'),
            'adult_number' => fake()->regexify('[0-9]{1}'),
            'kid_number' => fake()->regexify('[0-9]{1}'),
            'price' => fake()->regexify('[0-9]{3}'),
            'description' => fake()->sentence(),
            'is_active' => 1,
        ];
    }
}
