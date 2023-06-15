<?php

namespace App\Model\Entity;

class Unit
{
    /**Properties******************************************************************************************************/
    private int $id;
    private string $name;


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
        return htmlspecialchars_decode($this->name);
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