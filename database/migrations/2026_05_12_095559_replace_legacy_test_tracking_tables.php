<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop legacy tables
        Schema::dropIfExists('gn__test__responses');
        Schema::dropIfExists('gn__student_test_attempts');

        // Create new tracking tables
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('test_id')->constrained('test')->onDelete('cascade');
            $table->integer('test_attempt')->default(1);
            $table->enum('status', ['running', 'completed'])->default('running');
            $table->boolean('is_in_review')->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->unsignedBigInteger('last_section_id')->nullable();
            $table->unsignedBigInteger('last_question_id')->nullable();
            $table->json('draft_state')->nullable(); // Keeping this for any auxiliary UI state if needed
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('test_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_attempt_id')->constrained('test_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('question_bank')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->boolean('is_visited')->default(0);
            $table->boolean('is_marked_for_review')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempt_answers');
        Schema::dropIfExists('test_attempts');
        
        // No need to recreate legacy tables in down() as we are starting fresh
    }
};
