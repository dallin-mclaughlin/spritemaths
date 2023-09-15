<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id');
            $table->text('blurb')->nullable();
            $table->text('solution_logic');
            $table->json('graph_data')->nullable();
            $table->string('question');
            $table->string('submitted_answer')->nullable();
            $table->string('correct_answer');
            $table->json('data')->nullable();
            $table->boolean('is_correct')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_answers');
    }
};
