<?php

namespace App\Model\Entity;

class Unit
{
    private int $id;
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Unit
     */
    public function setId(int $id): Unit
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
     * @return Unit
     */
    public function setName(string $name): Unit
    {
        $this->name = $name;
        return $this;
    }


}