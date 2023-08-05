<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{

    public function run(): void
    {
      //topic: string
      //summary: text
        
      DB::table('topics')->insert([
        //1
        'topic' => 'Arithmetic',
        'summary' => 'Arithmetic, as a fundamental branch of 
                      mathematics, provides a profound framework 
                      for comprehending the enchanting interplay 
                      of numbers and their unyielding capacity to 
                      unlock a myriad of wonders across the 
                      boundless expanse of the universe.' 
      ]); 
      DB::table('topics')->insert([
        //2
        'topic' => 'Probability',
        'summary' => 'Probability, as a core concept in mathematics 
                      and statistics, entails quantifying the 
                      likelihood of various outcomes or events
                      occurring, allowing for a rigorous analysis 
                      of uncertainty and providing valuable insights 
                      in diverse fields ranging from science and 
                      finance to decision-making processes.' 
      ]); 
      DB::table('topics')->insert([
        //3
        'topic' => 'Geometry',
        'summary' => 'Geometry, a fundamental branch of mathematics, 
                      systematically investigates the properties, 
                      shapes, sizes, and relationships of geometric 
                      objects in both the Euclidean and non-Euclidean 
                      realms, underpinning the foundations of spatial 
                      understanding and serving as a crucial tool in 
                      diverse fields like architecture, physics, and 
                      computer graphics.' 
      ]);
      DB::table('topics')->insert([
        //4
        'topic' => 'Complex_Numbers',
        'summary' => 'Complex numbers, a pivotal extension of the 
                      real number system, encompass both a real part 
                      and an imaginary part represented by "i," 
                      facilitating the exploration and analysis of 
                      intricate mathematical phenomena, finding 
                      extensive applications in physics, engineering, 
                      and signal processing.' 
      ]); 
      DB::table('topics')->insert([
        //5
        'topic' => 'Differentiation',
        'summary' => 'Differentiation, a fundamental concept in 
                      calculus, involves computing the rate of 
                      change of a function at a specific point, 
                      enabling the investigation of slopes, velocities, 
                      and instantaneous rates of variation, which finds 
                      wide application in physics, engineering, and 
                      optimization problems.' 
      ]); 
      DB::table('topics')->insert([
        //6
        'topic' => 'Integration',
        'summary' => 'Integration, fundamental to calculus, 
                      encompasses the accumulation of infinitesimal 
                      quantities over an interval, enabling the 
                      determination of areas, volumes, and the net 
                      accumulation of quantities, serving as a 
                      cornerstone in mathematical modeling, physics, 
                      and economics.' 
      ]); 
      DB::table('topics')->insert([
        //7
        'topic' => 'Chance_and_Data',
        'summary' => 'Chance and data, a significant area in 
                      statistics, deals with the study of uncertainty,
                      probabilities, and the analysis of data through 
                      collection, organization, and interpretation, 
                      empowering decision-making processes, experimental 
                      design, and understanding real-world phenomena in 
                      various disciplines.' 
      ]);

    }
}
