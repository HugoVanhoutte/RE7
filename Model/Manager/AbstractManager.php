<?php

namespace App\Model\Manager;

abstract class AbstractManager
{
    public function getTimeFR($date_time): string
    {
        $date_time = explode(" ", $date_time);
        $date = explode("-", $date_time[0]);
        $time = explode(":", $date_time[1]);

        return $date[2] . "/" . $date[1] . "/" . $date[0] . " à " . $time[0] . "h" . $time[1];

    }
}