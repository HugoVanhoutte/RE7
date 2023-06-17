<?php

namespace App\Model\Manager;

abstract class AbstractManager
{
    /**
     * Allows to set the date to a format used in France,
     * Coming from the standard datetime format provided by the database
     * @param $date_time
     * @return string
     */
    public function getTimeFR(string $date_time): string
    {
        $date_time = explode(" ", $date_time);
        $date = explode("-", $date_time[0]);
        $time = explode(":", $date_time[1]);

        return $date[2] . "/" . $date[1] . "/" . $date[0] . " à " . $time[0] . "h" . $time[1];
    }

    /**
     * Removes potential threats from user entries
     * @param $userEntry
     * @return string
     */
    public function sanitize(string $userEntry): string
    {
        return htmlspecialchars(trim($userEntry));
    }
}