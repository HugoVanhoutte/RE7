<?php

namespace App\Model\Manager;

use App\Model\DB;

class RoleManager
{
    public function getRole($role_id): string
    {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $role_id);
        $stmt->execute();

        return $stmt->fetch()['role_name'];
    }
}