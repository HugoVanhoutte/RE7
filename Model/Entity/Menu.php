<?php

namespace App\Model\Entity;

class Menu
{
    private int $id;
    private string $name;
    private int $author_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Menu
     */
    public function setId(int $id): Menu
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Menu
     */
    public function setName(string $name): Menu
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param int $author_id
     * @return Menu
     */
    public function setAuthorId(int $author_id): Menu
    {
        $this->author_id = $author_id;
        return $this;
    }


}