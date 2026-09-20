<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->string('code', 20);
            $table->text('description')->nullable();
            $table->string('colour', 7)->default('#2563EB');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->unique(['user_id', 'code']);
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->dateTime('due_at');
            $table->string('priority')->default('medium');
            $table->string('status')->default('to_do');
            $table->unsignedSmallInteger('estimated_minutes')->nullable();
            $table->timestamps();

            $table->index(['course_id', 'status']);
            $table->index('due_at');
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 40);
            $table->string('colour', 7)->default('#64748B');
            $table->timestamps();

            $table->unique(['user_id', 'name']);
        });

        Schema::create('task_tag', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['task_id', 'tag_id']);
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->timestamps();
        });

        Schema::create('course_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('external_id');
            $table->string('title');
            $table->json('authors');
            $table->string('cover_url')->nullable();
            $table->timestamps();

            $table->unique(['course_id', 'external_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_resources');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('task_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('courses');
    }
};
