<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\User;

require_once "AbstractManager.php";
require_once "ManagerInterface.php";

class UserManager extends AbstractManager implements ManagerInterface
{
    /**
     * @inheritDoc
     */
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
                ->setToken($userData['token']);

        }
        return $users;
    }

    /**
     * @inheritDoc
     */
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
                ->setToken($data['token']);

        } else {
            return null;
        }
    }

    /**
     * gets user id from emailAdress
     * @param string $email
     * @return int
     */
    public function getIdFromEmail(string $email): int
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch()['id'];
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Inserts a user in DB
     * @param User $user
     * @return bool
     */
    public function insert(User $user): bool
    {
        $sql = "INSERT INTO users (username, email, password, token)
                VALUES (:username, :email, :password, :token)";
        $stmt = DB::getInstance()->prepare($sql);

        $username = $this->sanitize($user->getUsername());
        $email = $this->sanitize($user->getEmail());
        $password = $user->getPassword();
        $token = $user->getToken();

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':token', $token);

        return $stmt->execute();
    }


    /**
     * @inheritDoc
     */
    public function update(int $id, array $updateData = []): bool
    {
        $user = $this->get($id);
        if (!isset($updateData['username'])) {
            $username = $user->getUsername();
        } else {
            $username = $this->sanitize($updateData['username']);
        }

        if (!isset($updateData['email'])) {
            $email = $user->getEmail();
        } else {
            $email = $this->sanitize($updateData['email']);
        }

        if (!isset($updatedata['password'])) {
            $password = $user->getPassword();
        } else {
            $password = $updateData['password'];
        }

        if (!isset($updateData['role_id'])) {
            $role_id = $user->getRoleId();
        } else {
            $role_id = $updateData['role_id'];
        }

        if (isset($updateData['token'])) {
            // this 'if' statement is set to avoid an undefined array key "token"... error
            if (is_null($updateData['token'])) {
                $token = null;
            } else {
                $token = $updateData['token'] ?? $user->getToken();
            }
        }


        $sql = "UPDATE users SET username = :username, email = :email, password = :password, role_id = :role_id, token =:token WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
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

        return (bool)$stmt->fetch();
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

        return (bool)$stmt->fetch();
    }

    /**
     * returns true if email adress is in valid format
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
     * returns true if username is in valid format
     * @param string $username
     * @return bool
     */
    public function validateUsername(string $username): bool
    {
        return (strlen($username) >= 3 && strlen($username) <= 50);
    }

    /**
     * returns true if password is in valid format
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return (bool)preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}/", $password);
    }


    /**
     * returns true if current user is admin
     * @return bool
     */
    public function isAdmin(): bool
    {
        if (isset($_SESSION['user_id'])) {
            $currentUser = (new UserManager())->get($_SESSION['user_id']);
            return in_array($currentUser->getRoleId(), [1, 2, 3]);
        } else return false;
    }

    /**
     * returns true if current user is author of current page
     * @param $authorId
     * @return bool
     */
    public function isAuthor($authorId): bool
    {
        return (isset($_SESSION['user_id']) && $authorId === $_SESSION['user_id']);
    }

    /**
     * returns true if current has authorisations to remove content
     * @param $authorId
     * @return bool
     */
    public function isRemovable($authorId): bool
    {
        return $this->isAdmin() || $this->isAuthor($authorId);
    }
}