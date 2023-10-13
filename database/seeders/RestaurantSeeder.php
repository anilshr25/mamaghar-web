<?php

namespace Database\Seeders;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurant::factory()->count(100)->create();
    }
}
