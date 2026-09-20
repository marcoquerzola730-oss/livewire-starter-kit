<?php

namespace App\Models;

use Database\Factories\CourseResourceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['course_id', 'external_id', 'title', 'authors', 'cover_url'])]
class CourseResource extends Model
{
    /** @use HasFactory<CourseResourceFactory> */
    use HasFactory;

    /** @return BelongsTo<Course, $this> */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['authors' => 'array'];
    }
}
