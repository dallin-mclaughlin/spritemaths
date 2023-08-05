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
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Division',
        'question_summary' => 'Learn to Divide Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Division',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Multiplication', 
        'question_summary' => 'Learn to Multiply Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Multiplication',
        'is_demo' => true
      ]);
      DB::table('questions')->insert([
        'title' => 'Subtraction',
        'question_summary' => 'Learn to Subtract Numbers',
        'year_level_id' => 1,
        'topic_id' => 1,
        'points' => 1,
        'name_space'=>'Basic\Arithmetic\Subtraction',
        'is_demo' => true
      ]);
    }
}
