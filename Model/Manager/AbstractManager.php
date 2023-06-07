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
    public function getTimeFR($date_time): string
    {
        $date_time = explode(" ", $date_time);
        $date = explode("-", $date_time[0]);
        $time = explode(":", $date_time[1]);

        return $date[2] . "/" . $date[1] . "/" . $date[0] . " à " . $time[0] . "h" . $time[1];
    }

    /**
     * @return bool
     */
    public function isAdmin():bool {
        if (isset($_SESSION['user_id'])) {
            $currentUser = (new UserManager())->get($_SESSION['user_id']);
            return in_array($currentUser->getRoleId(), [1,2,3]);
        } else return false;
    }

    /**
     * @param $authorId
     * @return bool
     */
    public function isAuthor($authorId): bool {
        return (isset($_SESSION['user_id']) && $authorId === $_SESSION['user_id']);
    }

    /**
     * @param $authorId
     * @return bool
     */
    public function isRemovable($authorId): bool
    {
        return $this->isAdmin() || $this->isAuthor($authorId);
    }
}