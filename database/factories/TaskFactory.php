<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Task> */
class TaskFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'due_at' => fake()->dateTimeBetween('now', '+2 months'),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['to_do', 'in_progress', 'completed']),
            'estimated_minutes' => fake()->numberBetween(15, 240),
        ];
    }
}
