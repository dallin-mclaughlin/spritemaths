<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('year_levels')->insert([
        'year_level' => 'Basic',
        'min_age' => 5,
        'max_age' => 11 
      ]); 
      DB::table('year_levels')->insert([
        'year_level' => 'Intermediate',
        'min_age' => 11,
        'max_age' => 13 
      ]);
      DB::table('year_levels')->insert([
        'year_level' => 'Year_9',
        'min_age' => 13,
        'max_age' => 14 
      ]);
      DB::table('year_levels')->insert([
        'year_level' => 'Year_10',
        'min_age' => 14,
        'max_age' => 15 
      ]);
      DB::table('year_levels')->insert([
        'year_level' => 'Year_11',
        'min_age' => 15,
        'max_age' => 16 
      ]);
      DB::table('year_levels')->insert([
        'year_level' => 'Year_12',
        'min_age' => 16,
        'max_age' => 17 
      ]);
      DB::table('year_levels')->insert([
        'year_level' => 'Year_13',
        'min_age' => 17,
        'max_age' => 18 
      ]);
      DB::table('year_levels')->insert([
        'year_level' => 'Scholarship',
        'min_age' => 15,
        'max_age' => 18 
      ]);
    }
}

