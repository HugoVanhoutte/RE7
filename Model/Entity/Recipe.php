<?php

namespace App\Model\Entity;

class Recipe extends AbstractPost
{
    private string $title;
    private int $preparation_time_minutes;
    private int $cooking_time_minutes;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Recipe
     */
    public function setTitle(string $title): Recipe
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getPreparationTimeMinutes(): int
    {
        return $this->preparation_time_minutes;
    }

    /**
     * @param int $preparation_time_minutes
     * @return Recipe
     */
    public function setPreparationTimeMinutes(int $preparation_time_minutes): Recipe
    {
        $this->preparation_time_minutes = $preparation_time_minutes;
        return $this;
    }

    /**
     * @return int
     */
    public function getCookingTimeMinutes(): int
    {
        return $this->cooking_time_minutes;
    }

    /**
     * @param int $cooking_time_minutes
     * @return Recipe
     */
    public function setCookingTimeMinutes(int $cooking_time_minutes): Recipe
    {
        $this->cooking_time_minutes = $cooking_time_minutes;
        return $this;
    }


}