<?php

namespace Database\Seeders;

use App\Models\Room\Category\RoomCategory;
use Illuminate\Database\Seeder;

class RoomCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomCategory::factory()->count(100)->create();
    }
}
