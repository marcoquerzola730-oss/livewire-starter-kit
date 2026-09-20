<?php

namespace Tests\Feature;

use App\Models\Attachment;
use App\Models\Course;
use App\Models\CourseResource;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudyPlannerRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_owns_courses_and_course_contains_tasks(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->for($user)->create();
        $task = Task::factory()->for($course)->create();

        $this->assertTrue($user->courses->contains($course));
        $this->assertTrue($course->tasks->contains($task));
        $this->assertTrue($task->course->is($course));
    }

    public function test_task_and_tags_have_a_many_to_many_relationship(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->for($user)->create();
        $task = Task::factory()->for($course)->create();
        $tag = Tag::factory()->for($user)->create();

        $task->tags()->attach($tag);

        $this->assertTrue($task->fresh()->tags->contains($tag));
        $this->assertTrue($tag->fresh()->tasks->contains($task));
        $this->assertDatabaseHas('task_tag', [
            'task_id' => $task->id,
            'tag_id' => $tag->id,
        ]);
    }

    public function test_course_resource_authors_are_cast_to_an_array(): void
    {
        $resource = CourseResource::factory()->create([
            'authors' => ['Ada Lovelace', 'Grace Hopper'],
        ]);

        $this->assertSame(['Ada Lovelace', 'Grace Hopper'], $resource->authors);
    }

    public function test_deleting_a_course_cascades_to_its_related_records(): void
    {
        $course = Course::factory()->create();
        $task = Task::factory()->for($course)->create();
        $attachment = Attachment::factory()->for($task)->create();
        $resource = CourseResource::factory()->for($course)->create();

        $course->delete();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseMissing('attachments', ['id' => $attachment->id]);
        $this->assertDatabaseMissing('course_resources', ['id' => $resource->id]);
    }

    public function test_admin_factory_creates_an_admin_user(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertSame('admin', $admin->role);
    }
}
