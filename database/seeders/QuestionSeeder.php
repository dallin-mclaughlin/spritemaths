<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('topics')->insert([
        'question_summary' => 'Learn to Add Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'namespace'=>'Basic\Arithmetic\Addition',
        'is_demo' => true
      ],
      [
        'question_summary' => 'Learn to Divide Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'namespace'=>'Basic\Arithmetic\Division',
        'is_demo' => true
      ],
      [
        'question_summary' => 'Learn to Multiply Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'namespace'=>'Basic\Arithmetic\Multiplication',
        'is_demo' => true
      ],
      [
        'question_summary' => 'Learn to Subtract Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'namespace'=>'Basic\Arithmetic\Subtraction',
        'is_demo' => true
      ],
    );
    }
}
