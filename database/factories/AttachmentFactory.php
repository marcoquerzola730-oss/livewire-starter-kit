<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Attachment> */
class AttachmentFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        $filename = fake()->uuid().'.pdf';

        return [
            'task_id' => Task::factory(),
            'original_name' => fake()->lexify('study-notes-????').'.pdf',
            'path' => 'task-attachments/'.$filename,
            'mime_type' => 'application/pdf',
            'size' => fake()->numberBetween(1000, 2_000_000),
        ];
    }
}
