<?php

namespace App\Manager;

use App\Model\DB;
use User;

class UserManager implements ManagerInterface
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $users = [];
        $data = $stmt->fetchAll();
        foreach ($data as $userData) {

            $users[] = (new User())
                ->setId($userData['id'])
                ->setUsername($userData['username'])
                ->setEmail($userData['email'])
                ->setPassword($userData['password'])
                ->setTimestamp($userData['timestamp'])
                ->setProfilePictureLink($userData['profilePictureLink'])
                ->setIsAdmin((bool)$userData['isAdmin'])
                //TODO Check if casts works
                ;

        }
        return $users;
    }

    public function get(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($data = $stmt->fetch()) {

        return (new User())
            ->setId($data['id'])
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setTimestamp($data['timestamp'])
            ->setProfilePictureLink($data['profilePictureLink'])
            ->setIsAdmin((bool)$data['isAdmin'])
            //TODO Check if casts works
        ;

        } else {
            return null;
        }
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function insert(array $content): bool
    {
        $sql = "INSERT INTO users (username, email, password, profilePictureLink)
                VALUES (:username, :email, :password, :profilePictureLink)";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':username', $content['username']);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':profilePictureLink', $profilePictureLink);

        return $stmt->execute();
    }

    public function update(int $id, array $content): bool
    {
        $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }
}