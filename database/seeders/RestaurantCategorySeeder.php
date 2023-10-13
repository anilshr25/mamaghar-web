<?php

namespace Database\Seeders;

use App\Models\Restaurant\Category\RestaurantCategory;
use Illuminate\Database\Seeder;

class RestaurantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantCategory::factory()->count(100)->create();
    }
}
