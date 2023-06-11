<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Recipe;

class RecipeManager extends AbstractManager implements ManagerInterface
{

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM recipes";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $recipes = [];
        $data = $stmt->fetchAll();
        foreach($data as $recipeData) {
            $recipes[] = (new Recipe())
                ->setId($recipeData['id'])
                ->setTitle($recipeData['title'])
                ->setContent($recipeData['content'])
                ->setAuthorId($recipeData['author_id'])
                ->setCreationDateTime($recipeData['creation_date_time'])
                ->setPreparationTimeMinutes($recipeData['preparation_time_minutes'])
                ->setCookingTimeMinutes($recipeData['cooking_time_minutes'])
                ;
        }
        return $recipes;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?object
    {
        $sql = "SELECT * FROM recipes where id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($data = $stmt->fetch()) {
            return (new Recipe())
                ->setId($data['id'])
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setAuthorId($data['author_id'])
                ->setCreationDateTime($data['creation_date_time'])
                ->setPreparationTimeMinutes($data['preparation_time_minutes'])
                ->setCookingTimeMinutes($data['cooking_time_minutes'])
            ;

        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM recipes WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $updateData = []): bool
    {
        $recipe = $this->get($id);

        $title = $this->sanitize($updateData['title']) ?? $recipe->getTitle();
        $content = $this->sanitize($updateData['content']) ?? $recipe->getContent();
        $preparationTimeMinutes = $updateData['preparation_time_minutes'] ?? $recipe->getPreparationTimeMinutes();
        $cookingTimeMinutes = $updateData['cooking_time_minutes'] ?? $recipe->getCookingTimeMinutes();



        $sql = "UPDATE recipes SET title = :title, content = :content, preparation_time_minutes = :preparation_time_minutes, cooking_time_minutes = :cooking_time_minutes WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':preparation_time_minutes', $preparationTimeMinutes);
        $stmt->bindParam(':cooking_time_minutes', $cookingTimeMinutes);
        return $stmt->execute();
    }

    public function insert(Recipe $recipe): int
    {
        $sql = "INSERT INTO recipes (title, content, author_id, preparation_time_minutes, cooking_time_minutes)
                VALUES (:title, :content, :author_id, :preparation_time_minutes, :cooking_time_minutes)";

        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $title = $this->sanitize($recipe->getTitle());
        $content = $this->sanitize($recipe->getContent());
        $authorId = $recipe->getAuthorId();
        $preparationTimeMinutes = $recipe->getPreparationTimeMinutes();
        $cookingTimeMinutes = $recipe->getCookingTimeMinutes();

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content',$content);
        $stmt->bindParam(':author_id',$authorId);
        $stmt->bindParam(':preparation_time_minutes',$preparationTimeMinutes);
        $stmt->bindParam(':cooking_time_minutes',$cookingTimeMinutes);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    public function getRecipesByAuthorId($author_id): array
    {
        $sql = "SELECT * FROM recipes WHERE author_id = :author_id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':author_id',$author_id);

        $stmt->execute();

        $recipes = [];
        $data = $stmt->fetchAll();
        foreach ($data as $recipeData) {
            $recipes[] = (new Recipe())
                ->setId($recipeData['id'])
                ->setTitle($recipeData['title'])
                ->setContent($recipeData['content'])
                ->setAuthorId($recipeData['author_id'])
                ->setCreationDateTime($recipeData['creation_date_time'])
                ->setPreparationTimeMinutes($recipeData['preparation_time_minutes'])
                ->setCookingTimeMinutes($recipeData['cooking_time_minutes'])
                ;
        }

        return $recipes;
    }

    public function get3MostRecent(): array
    {
        $sql = "SELECT * FROM recipes ORDER BY creation_date_time DESC";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $recipes = [];
        $data = $stmt->fetchAll();
        foreach($data as $recipeData) {
            $recipes[] = (new Recipe())
                ->setId($recipeData['id'])
                ->setTitle($recipeData['title'])
                ->setContent($recipeData['content'])
                ->setAuthorId($recipeData['author_id'])
                ->setCreationDateTime($recipeData['creation_date_time'])
                ->setPreparationTimeMinutes($recipeData['preparation_time_minutes'])
                ->setCookingTimeMinutes($recipeData['cooking_time_minutes'])
            ;
        }
        return $recipes;
    }

    public function getNumberRecipePerUser(int $user_id): int
    {
        $sql = "SELECT count(*) AS number FROM recipes WHERE author_id = :author_id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':author_id', $user_id);

        $stmt->execute();
        return $stmt->fetch()['number'];
    }
}