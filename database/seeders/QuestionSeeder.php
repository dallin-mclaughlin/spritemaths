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
      DB::table('questions')->insert([
        'title' => 'Addition',
        'question_summary' => 'Learn to Add Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Addition',
        'question_type'=>'basic',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Division',
        'question_summary' => 'Learn to Divide Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Division',
        'question_type'=>'basic',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Multiplication', 
        'question_summary' => 'Learn to Multiply Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Multiplication',
        'question_type'=>'basic',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Subtraction',
        'question_summary' => 'Learn to Subtract Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Subtraction',
        'question_type'=>'basic',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Algebra',
        'question_summary' => 'Solve for unknowns',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Algebra',
        'question_type'=>'basic',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Currency',
        'question_summary' => 'Convert between dollar values',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Conversions\Currency',
        'question_type'=>'basic',
        'is_demo' => true
      ]);
    }
}
