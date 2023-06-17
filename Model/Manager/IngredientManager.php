<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Ingredient;

class IngredientManager extends AbstractManager implements ManagerInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM ingredients";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $ingredients = [];
        foreach ($data as $ingredientData) {
            $ingredients[] = (new Ingredient())
                ->setId($ingredientData['id'])
                ->setName($ingredientData['name']);
        }

        return $ingredients;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?object
    {
        $sql = "SELECT * FROM ingredients WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();
        return (new Ingredient)
            ->setId($data['id'])
            ->setName($data['name']);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM ingredients WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $updateData = []): bool
    {
        $ingredient = $this->get($id);
        /* @var Ingredient $ingredient */

        $name = $this->sanitize($updateData['name']) ?? $ingredient->getName();

        $sql = "UPDATE ingredients SET name = :name WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    /**
     * inserts a ingredient in DB
     * @param string $name
     * @return int
     */
    public function insert(string $name): int
    {
        $sql = "INSERT INTO ingredients (name)
                VALUES (:name)";
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $name = $this->sanitize($name);

        $stmt->bindParam(':name', $name);

        $stmt->execute();

        return $pdo->lastInsertId();
    }
}