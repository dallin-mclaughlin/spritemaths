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
        Schema::create('quiz_questions_answers', function (Blueprint $table) {
            $table->id();
            $table->enum('question_type', ['basic','graph','table']);
            $table->string('question');
            $table->json('submitted_answer');
            $table->json('correct_answer');
            $table->json('graph')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions_answers');
    }
};
