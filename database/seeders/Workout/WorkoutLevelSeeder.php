<?php

namespace Database\Seeders\Workout;

use App\Models\Workout\WorkoutLevel;
use Illuminate\Database\Seeder;

class WorkoutLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkoutLevel::factory(3)->create();
    }
}