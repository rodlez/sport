<?php

namespace Database\Seeders\Sport;

use App\Models\Sport\SportCategory;
use Illuminate\Database\Seeder;

class SportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SportCategory::factory(10)->create();
    }
}