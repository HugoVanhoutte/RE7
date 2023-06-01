<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Comment;

class CommentManager extends AbstractManager implements ManagerInterface
{

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $sql="SELECT * FROM comments";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->execute();
        $data = $stmt->fetchAll();

        $comments = [];

        foreach($data as $commentData) {
            $comments[] = (new Comment())
                ->setId($commentData['id'])
                ->setContent($commentData['content'])
                ->setAuthorId($commentData['author_id'])
                ->setCreationDateTime($commentData['creation_date_time'])
                ->setRecipeId($commentData['recipe_id'])
                ;
        }
        return $comments;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?object
    {
        $sql = "SELECT * FROM comments WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if($data = $stmt->fetch()) {
            return (new Comment())
                ->setId($data['id'])
                ->setContent($data['content'])
                ->setAuthorId($data['author_id'])
                ->setCreationDateTime($data['creation_date_time'])
                ->setRecipeId($data['recipe_id'])
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
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $updateData = []): bool
    {
        $comment = $this->get($id);

        $content = $updateData['content'] ?? $comment->getContent();

        $sql = "UPDATE comments SET content = :content WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    /**
     * @param Comment $comment
     * returns the newly inserted ID
     * @return int
     */
    public function insert(Comment $comment): int
    {
        $sql = "INSERT INTO comments (content, author_id, recipe_id)
                VALUES (:content, :author_id, :recipe_id)";
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $content = $comment->getContent();
        $authorId = $comment->getAuthorId();
        $recipeId = $comment->getRecipeId();

        $stmt->bindParam(':content',$content);
        $stmt->bindParam(':author_id',$authorId);
        $stmt->bindParam(':recipe_id',$recipeId);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    public function getCommentsByAuthorId($authorId)
    {
        $sql = "SELECT * FROM comments WHERE author_id = :author_id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':author_id', $authorId);
        $stmt->execute();

        $comments = [];
        $data = $stmt->fetchAll();
        foreach($data as $commentData) {
            $comments[] = (new Comment())
                ->setId($commentData['id'])
                ->setContent($commentData['content'])
                ->setAuthorId($commentData['author_id'])
                ->setCreationDateTime($commentData['creation_date_time'])
                ->setRecipeId($commentData['recipe_id'])
                ;
        }

        return $comments;
    }

    public function getCommentsByRecipeId($recipeId)
    {

        $sql = "SELECT * FROM comments WHERE recipe_id = :recipe_id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':recipe_id', $recipeId);
        $stmt->execute();

        $comments = [];
        $data = $stmt->fetchAll();
        foreach($data as $commentData) {
            $comments[] = (new Comment())
                ->setId($commentData['id'])
                ->setContent($commentData['content'])
                ->setAuthorId($commentData['author_id'])
                ->setCreationDateTime($commentData['creation_date_time'])
                ->setRecipeId($commentData['recipe_id'])
            ;
        }

        return $comments;
    }
}