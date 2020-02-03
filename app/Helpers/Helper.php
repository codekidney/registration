<?php

namespace App\Helpers;

use App\Helpers\Pesel;
use \DateTime;
use DateInterval;

class Helper {

    public static function peselDate(string $string) {
        return Pesel::extractDate($string);
    }

    public static function propByComma(object $obj, string $prop){
        if( is_object($obj) && isset($obj->$prop) ){
            return implode(', ', array_map(function($lang) { return $lang['name']; }, $obj->$prop->toArray()));
        } else {
            return null;
        }
    }
    
    public static function age(DateTime $birthdate){
        $today = new DateTime();
        if($birthdate < $today){
            $interval = $today->diff( $birthdate );
            return $interval->y;
        }
        return null;
    }
    
    public static function timeToMaturity(DateTime $birthdate){
        $today = new DateTime();
        $maturity = 18;
        $maturitydate = clone $birthdate;
        $maturitydate->add( new DateInterval('P'.$maturity.'Y') );
        if($birthdate < $maturitydate && $maturitydate > $today){
            // years
            $interval = $today->diff( $maturitydate );
            $years = $interval->y;
            
            // and days
            $maturitydateWithoutYears = $maturitydate->sub( new DateInterval('P'.$years.'Y') );
            $intervalDays = $today->diff( $maturitydateWithoutYears );
            $days = $intervalDays->days;
            
            if($interval->y < $maturity){
                $result = new \stdClass();
                $result->years = $years;
                $result->days = $days;
                return $result;
            }
        }
        return null;
    }
}
