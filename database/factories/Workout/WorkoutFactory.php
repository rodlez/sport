<?php

namespace Database\Factories\Workout;

use App\Models\Workout\WorkoutType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workout\Workout>
 */
class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => implode(WorkoutType::get()->pluck('id')->random(1)->toArray()),
            'title' => fake()->sentence(4,true),            
            'author' => fake()->word(),
            'duration' => fake()->numberBetween(10, 200),
            'url' => fake()->url(),
            'description' => fake()->text(),
        ];
    }
}
