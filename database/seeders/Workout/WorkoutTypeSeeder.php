<?php

namespace Database\Seeders\Workout;

use App\Models\Workout\WorkoutType;
use Illuminate\Database\Seeder;

class WorkoutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkoutType::factory(10)->create();
    }
}