<?php

namespace App\Model\Entity;

class Ingredient
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
     * @return Ingredient
     */
    public function setId(int $id): Ingredient
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
     * @return Ingredient
     */
    public function setName(string $name): Ingredient
    {
        $this->name = $name;
        return $this;
    }


}