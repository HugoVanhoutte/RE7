<?php

namespace App\Model\Manager;

use App\Model\DB;

class Menu_RecipeManager extends AbstractManager
{

    public function getFromMenu(int $menuId): array
    {
        $sql = "SELECT recipes.id as recipe_id FROM menu_recipes

                JOIN recipes ON menu_recipes.recipe_id = recipes.id
                WHERE menu_recipes.menu_id = :menu_id";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':menu_id', $menuId);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function delete(int $id): bool
    {
        $sql = "DELETE FROM menu_recipes WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function insert(array $data): int
    {
        $sql = "INSERT INTO menu_recipes (menu_id, recipe_id)
                VALUES (:menu_id, :recipe_id)";
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':menu_id',$data['menu_id']);
        $stmt->bindParam(':recipe_id',$data['recipe_id']);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    public function deleteAllFromMenu(int $menuId): bool
    {
        $sql = "DELETE FROM menu_recipes WHERE menu_id = :menu_id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':menu_id', $menuId);

        return $stmt->execute();
    }
}