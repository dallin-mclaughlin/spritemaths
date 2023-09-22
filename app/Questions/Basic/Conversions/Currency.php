<?php

namespace App\Questions\Basic\Conversions;

use App\Questions\Question;

    class Currency extends Question{

        private $initialUnit;
        private $units = ['£','€','US $','AUS $','NZ $','¥'];

        function __construct(){
            $bitCoin = ['₿'=>0.0000252];
            $unitsConversions = ['£'=>0.80,'€'=>0.94,'US $'=>1,'AUS $'=>1.38,
                                'NZ $'=>1.53,'¥'=>6.61];

            $this->initialUnit = $this->units[random_int(0,count($this->units)-1)];
            $finalUnit = $this->getFinalUnit($this->initialUnit);

            $initialValue = $this->getRandomValue($this->initialUnit);
            $finalValue = round($initialValue*$unitsConversions[$finalUnit]/$unitsConversions[$this->initialUnit], 2);
            $beginning = $this->addCurrencyListing($unitsConversions);
            $this->setBlurb($beginning);
            $this->setQuestion('Convert '.$this->initialUnit.'\\('.$initialValue.
                                ' \\) into '.$this->getUnitWord($finalUnit).' '.$finalUnit);
            $this->setAnswer($finalValue);
        }

        function getRandomValue($unit)
        {
            if($unit == "₿"){
                return random_int(1,9) * 100;
            } else if($unit == "£"){
                return random_int(1,999) * 100;
            } else if($unit == "€"){
                return random_int(1,999) / 100;
            } else if($unit == "US $"){
                return random_int(1,999) / 10;
            } else if($unit == "AUS $"){
                return random_int(1,999) / 10;
            } else if($unit == "NZ $"){
                return random_int(1,999) / 10;
            } else if($unit == "¥"){
                return random_int(1,999) / 10;
            }
        }

        function getUnitWord($unit){
            if($unit == "₿"){
                return 'Bitcoins';
            } else if($unit == "£"){
                return 'British Pounds';
            } else if($unit == "€"){
                return 'Euros';
            } else if($unit == "US $"){
                return 'US dollars';
            } else if($unit == "AUS $"){
                return 'Australian dollars';
            } else if($unit == "NZ $"){
                return 'NZ dollars';
            } else if($unit == "¥"){
                return 'Chinese Yuan';
            } 
        }

        function getFinalUnit($initialUnit){
            $finalUnit = $this->units[random_int(0,count($this->units)-1)];
            while($finalUnit == $this->initialUnit){
                $finalUnit = $this->units[random_int(0,count($this->units)-1)];
            }
            return $finalUnit;
        }

        function addCurrencyListing($currencyUnits){
            $symbols = array_keys($currencyUnits);
            $information = '';
            foreach($symbols as $symbol){
                $information = $information.'\\(1\\) US dollar  = '.$symbol.'\\('.number_format($currencyUnits[$symbol],2).'\\), ';
            }
            $information = substr($information, 0, -2);
            return "Given".$information.". Round to \\(2\\) d.p.";
        }
       
    }
//I can construct this 
?>