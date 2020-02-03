<?php

namespace App\Faker;

use DateTime;
use Faker\Provider\Base;
use Faker\Provider\DateTime as FakerDateTime;

class FakerProvider extends Base {

    public function programmingLanguage() {
        $lang = ['Python','Java','JavaScript','PHP','Go','Rust','Kotlin','Ruby','Swift','Dart','Haskell','TypeScript'];
        $keys = array_rand($lang,1);
        return $lang[$keys];
    }

    /**
     * PESEL - Universal Electronic System for Registration of the Population
     * @link http://en.wikipedia.org/wiki/PESEL
     * @param  DateTime $birthdate
     * @param  string   $sex       M for male or F for female
     * @return string   11 digit number, like 44051401358
     */
    public function pesel($birthdate = null, $sex = null)
    {
        if ($birthdate === null) {
            $birthdate = FakerDateTime::dateTimeThisCentury();
        }

        $weights = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3);
        $length = count($weights);

        $fullYear = (int) $birthdate->format('Y');
        $year = (int) $birthdate->format('y');
        $month = $birthdate->format('m') + (((int) ($fullYear/100) - 14) % 5) * 20;
        $day = $birthdate->format('d');

        $result = array((int) ($year / 10), $year % 10, (int) ($month / 10), $month % 10, (int) ($day / 10), $day % 10);

        for ($i = 6; $i < $length; $i++) {
            $result[$i] = static::randomDigit();
        }

        $result[$length - 1] |= 1;
        if ($sex == "F") {
            $result[$length - 1] -= 1;
        }

        $checksum = 0;
        for ($i = 0; $i < $length; $i++) {
            $checksum += $weights[$i] * $result[$i];
        }
        $checksum = (10 - ($checksum % 10)) % 10;
        $result[] = $checksum;

        return implode('', $result);
    }
}
