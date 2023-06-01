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

    /**
     * @param $author_id
     * @return bool
     */
    public function isEditable($author_id): bool
    {
        if($author_id === $_SESSION['user_id'] || in_array(((new userManager)->get($author_id))->getRoleId(), [1,2,3]))  //Check if the current user is either a SuperAdmin, Admin moderator or the author/page owner
        {
            return true;
        } else {
            return false;
        }
    }
}