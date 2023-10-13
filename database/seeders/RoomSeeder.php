<?php

namespace Database\Seeders;

use App\Models\Room\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::factory()->count(100)->create();
    }
}
