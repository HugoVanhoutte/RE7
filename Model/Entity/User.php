<?php

namespace App\Model\Entity;

class User
{
    /**Properties******************************************************************************************************/
    private int $id;
    private string $username;
    //At most 50 characters
    private string $email;
    private string $password;
    //Hashed automatically on set Method ?
    private string $timestamp;
    private string $profilePictureLink;
    private bool $isAdmin;




    /**Getters And Setters*********************************************************************************************/

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     * @return User
     */
    public function setTimestamp(string $timestamp): User
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfilePictureLink(): string
    {
        return $this->profilePictureLink;
    }

    /**
     * @param string $profilePictureLink
     * @return User
     */
    public function setProfilePictureLink(string $profilePictureLink): User
    {
        $this->profilePictureLink = $profilePictureLink;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin(bool $isAdmin): User
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }
}