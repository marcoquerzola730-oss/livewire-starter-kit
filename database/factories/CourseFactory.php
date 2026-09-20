<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Course> */
class CourseFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement(['Web Application Development', 'Database Design', 'Software Engineering']),
            'code' => strtoupper(fake()->unique()->bothify('???####')),
            'description' => fake()->sentence(),
            'colour' => fake()->hexColor(),
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+4 months'),
        ];
    }
}
