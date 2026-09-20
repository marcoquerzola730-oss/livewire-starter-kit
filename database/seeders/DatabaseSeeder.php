<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseResource;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Demo Administrator',
            'email' => 'admin@example.com',
        ]);

        $student = User::factory()->create([
            'name' => 'Demo Student',
            'email' => 'student@example.com',
        ]);

        $course = Course::factory()->for($student)->create([
            'title' => 'Web Application Development',
            'code' => 'WAD2026',
        ]);

        $tasks = Task::factory()->count(4)->for($course)->create();

        $urgent = Tag::factory()->for($student)->create([
            'name' => 'Urgent',
            'colour' => '#DC2626',
        ]);
        $assignment = Tag::factory()->for($student)->create([
            'name' => 'Assignment',
            'colour' => '#7C3AED',
        ]);

        $tasks->firstOrFail()->tags()->attach([$urgent->id, $assignment->id]);

        CourseResource::factory()->for($course)->create([
            'external_id' => '/works/OL45804W',
            'title' => 'The Pragmatic Programmer',
            'authors' => ['David Thomas', 'Andrew Hunt'],
        ]);
    }
}
