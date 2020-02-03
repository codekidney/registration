<?php

namespace App\Helpers;

class Pesel {

    public static function extractSex($pesel) {
        return intval(substr($pesel, 9, 1)) % 2 == 0 ? 1 : 2;
    }

    public static function extractDate($pesel) {
        list($year, $month, $day) = sscanf($pesel, '%02s%02s%02s');
        switch (substr($month, 0, 1)) {
            case 2:
            case 3:
                $month -= 20;
                $year += 2000;
                break;
            case 4:
            case 5:
                $month -= 40;
                $year += 2100;
            case 6:
            case 7:
                $month -= 60;
                $year += 2200;
                break;
            case 8:
            case 9:
                $month -= 80;
                $year += 1800;
                break;
            default:
                $year += 1900;
                break;
        }
        return checkdate($month, $day, $year) ? new \DateTime("$year/$month/$day") : null;
    }

}
