<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\User;

require_once "AbstractManager.php";
class UserManager extends AbstractManager implements ManagerInterface
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
                ->setRegistrationDateTime($userData['registration_date_time'])
                ->setRoleId($userData['role_id'])
                ->setToken($userData['token'])
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
            ->setRegistrationDateTime($data['registration_date_time'])
            ->setRoleId($data['role_id'])
            ->setToken($data['token'])
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

    public function insert(User $user): bool
    {
        $sql = "INSERT INTO users (username, email, password, token)
                VALUES (:username, :email, :password, :token)";
        $stmt = DB::getInstance()->prepare($sql);
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $token = $user->getToken();

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':token', $token);

        return $stmt->execute();
    }



    public function update(int $id, array $updateData = []): bool
    {
        $user = $this->get($id);

        $username = $updateData['username'] ?? $user->getUsername();
        $email = $updateData['email'] ?? $user->getEmail();
        $password = $updateData['password'] ?? $user->getPassword();
        $registration_date_time = $updateData['registration_date_time'] ?? $user->getRegistrationDateTime();
        $role_id = $updateData['role_id'] ?? $user->getRoleId();
        if (isset($updateData['token'])) {
            // this 'if' statement is set to avoid an undefined array key "token"... error
            if (is_null($updateData['token'])) {
                $token = null;
            } else {
                $token = $updateData['token'] ?? $user->getToken();
            }
        }


        $sql = "UPDATE users SET username = :username, email = :email, password = :password, registration_date_time = :registration_date_time, role_id = :role_id, token =:token WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':registration_date_time', $registration_date_time);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':token', $token);

        return $stmt->execute();
    }

    /**
     * returns true if an email address is already in DB
     * @param string $email
     * @return bool
     */
    public function checkEmailAlreadyInDB(string $email): bool
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    /**
     * returns true if a username is already in use in DB
     * @param string $username
     * @return bool
     */
    public function checkUsernameAlreadyInDB(string $username): bool
    {
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    /**
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $username
     * @return bool
     */
    public function validateUsername(string $username): bool
    {
        return (strlen($username) > 3 && strlen($username) <= 50);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return (bool) preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}/", $password);
    }

    /**
     * @param $author_id
     * @return bool
     */
    public function isEditable($author_id): bool
    {
        if($author_id === $_SESSION['user_id'] || in_array(($this->get($author_id))->getRoleId(), [1,2,3]))  //Check if the current user is either a SuperAdmin, Admin moderator or the author/page owner
        {
            return true;
        } else {
            return false;
        }
    }
}