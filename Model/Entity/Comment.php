<?php

namespace App\Model\Entity;

class Comment extends AbstractPost
{
    /**Properties******************************************************************************************************/
    private int $recipe_id;


    /**Getters And Setters*********************************************************************************************/
    /**
     * @return int
     */
    public function getRecipeId(): int
    {
        return $this->recipe_id;
    }

    /**
     * @param int $recipe_id
     * @return Comment
     */
    public function setRecipeId(int $recipe_id): Comment
    {
        $this->recipe_id = $recipe_id;
        return $this;
    }


}