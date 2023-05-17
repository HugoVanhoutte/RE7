<?php

namespace App\Manager;

use App\Model\DB;
use PDO;
use App\Model\Entity\User;

require "../Entity/User.php";

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

    public function getIdFromEmail(string $email): int
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch()['id'];
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function insert(array $userData): bool
    {
        $sql = "INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':username', $userData['username']);
        $stmt->bindParam(':email', $userData['email']);
        $stmt->bindParam(':password', $userData['password']);

        return $stmt->execute();
    }

    public function insertUnconfirmedUser(array $userData): bool
    {
        $sql = "INSERT INTO unconfirmed_users (username, email, password, token)
                VALUES (:username, :email, :password, :token)";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':username', $userData['username']);
        $stmt->bindParam(':email', $userData['email']);
        $stmt->bindParam(':password', $userData['password']);
        $stmt->bindParam(':token', $userData['token']);

        return $stmt->execute();
    }

    public function getUnconfirmedUserByToken($token):array {
        $sql = "SELECT id, email, username, password FROM unconfirmed_users WHERE token = :token";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function deleteUnconfirmedUser(int $id): bool {
        $sql = "DELETE FROM unconfirmed_users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update(int $id, array $userData): bool
    {
        $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $userData['username']);
        $stmt->bindParam(':email', $userData['email']);
        $stmt->bindParam(':password', $userData['password']);

        return $stmt->execute();
    }

    public function checkEmailAlreadyInDB(string $email): bool
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
        //TODO Check IF THAT WORKS
    }

    public function checkUsernameAlreadyInDB(string $username): bool
    {
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
        //TODO Check IF THAT WORKS
    }

    public function validateEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        } else {
            return false;
        }
        //TODO CHECK
    }

    public function validateUsername(string $username): bool
    {
        return (strlen($username) > 3 && strlen($username) <= 50);
        //TODO CHECK
    }

    public function validatePassword(string $password): bool
    {
        return (bool) preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}/", $password);
    }

    public function validateLogin(string $email, string $password): int|false
    {
        $user = $this->get($this->getIdFromEmail($email));
        if (empty($user)){
            return false;
        } else {
            if (password_verify($password, $user['password'])) {
                return $user->getId();
            } else {
                return false;
            }
        }
    }
}