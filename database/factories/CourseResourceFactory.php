<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CourseResource> */
class CourseResourceFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'external_id' => '/works/'.strtoupper(fake()->unique()->bothify('OL#######W')),
            'title' => fake()->sentence(4),
            'authors' => [fake()->name()],
            'cover_url' => fake()->optional()->url(),
        ];
    }
}
