<?php

namespace App\Helpers;

class DateHelper
{
    public static function getPast5Days()
    {
        $dates = array();
        $count = 1;
        while (count($dates) < 6) {
            $day = date('Y-m-d', strtotime("-$count day"));
            if (self::isWeekend($day)) {
                $count++;
                continue;
            } else {
                $dates[] = date('Y-m-d', strtotime("-$count day"));
                $count++;
            }
        }
        return $dates;
    }

    public static function isWeekend($date)
    {
        return (date('N', strtotime($date)) >= 6);
    }
}
