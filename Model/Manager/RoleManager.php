<?php

namespace App\Model\Manager;

use App\Model\DB;

class RoleManager
{
    /**
     * gets role name based on ID
     * @param $role_id
     * @return string
     */
    public function getRole($role_id): string
    {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $role_id);
        $stmt->execute();

        return $stmt->fetch()['role_name'];
    }
}