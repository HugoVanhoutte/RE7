<?php

namespace App\Model\Manager;

use App\Model\DB;

class Recipe_IngredientManager extends AbstractManager
{

    /**
     * gets all ingredients (with their quantities and units) from a recipe
     * @param int $recipeId
     * @return array
     */
    public function getFromRecipe(int $recipeId): array
    {
        $sql = "SELECT ingredients.id as ingredient_id, ingredients.name, units.id as unit_id, units.name as unit_name, recipe_ingredients.quantity
    FROM recipe_ingredients
        
    JOIN ingredients ON recipe_ingredients.ingredient_id = ingredients.id
    JOIN units ON recipe_ingredients.unit_id = units.id
    WHERE recipe_ingredients.recipe_id = :recipe_id";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':recipe_id', $recipeId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * deletes a recipe/ingredient joint
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM recipe_ingredients WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * insert a new recipe/ingredient joint
     * @param array $data
     * @return int
     */
    public function insert(array $data): int
    {
        $sql = "INSERT INTO recipe_ingredients (recipe_id, ingredient_id, unit_id, quantity) 
                VALUES (:recipe_id, :ingredient_id, :unit_id, :quantity)";
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':recipe_id', $data['recipe_id']);
        $stmt->bindParam(':ingredient_id', $data['ingredient_id']);
        $stmt->bindParam(':unit_id', $data['unit_id']);
        $stmt->bindParam(':quantity', $data['quantity']);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    /**
     * delete all recipe/ingredients joint of a recipe (usually when a recipe is deleted)
     * @param int $recipeId
     * @return bool
     */
    public function deleteAllFromRecipe(int $recipeId): bool
    {
        $sql = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe_id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':recipe_id', $recipeId);

        return $stmt->execute();
    }
}