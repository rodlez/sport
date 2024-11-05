<?php

namespace Database\Seeders\Workout;

use App\Models\Workout\Workout;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workout::factory(10)->create();
    }
}
