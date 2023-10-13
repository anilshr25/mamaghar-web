<?php

namespace Database\Seeders;

use App\Models\Cms\Faq\Category\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FaqCategory::factory()->count(100)->create();
    }
}
