<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Menu;

class MenuManager extends AbstractManager implements ManagerInterface
{

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM menus";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();

        $menus = [];

        $data = $stmt->fetchAll();
        foreach ($data as $menuData) {
            $menus[] = (new Menu())
                ->setId($menuData['id'])
                ->setName($menuData['name'])
                ->setAuthorId($menuData['author_id'])
                ;
        }
        return $menus;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?object
    {
        $sql = "SELECT * FROM menus WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();
        return (new Menu())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setAuthorId($data['author_id'])
            ;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM menus WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $updateData = []): bool
    {
        $menu = $this->get($id);
        /* @var Menu $menu */
        $name = $this->sanitize($updateData["name"]) ?? $menu->getName();


        $sql = "UPDATE menus SET name = :name WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    public function insert(Menu $menu): int
    {
        $sql = "INSERT INTO menus (name, author_id)
                VALUES (:name, :author_id)";
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $name = $this->sanitize($menu->getName());
        $authorId = $menu->getAuthorId();

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':author_id', $authorId);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    public function getMenusByAuthorId(int $authorId): array
    {
        $sql = "SELECT * FROM menus WHERE author_id = :author_id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':author_id', $authorId);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $menus = [];
        foreach ($data as $menuData) {
            $menus[] = (new Menu())
                ->setId($menuData['id'])
                ->setName($menuData['name'])
                ->setAuthorId($menuData['author_id'])
                ;
        }

        return $menus;
    }

    public function getNumberMenusPerUser($userId): int
    { $sql = "SELECT count(*) AS number FROM menus WHERE author_id = :author_id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':author_id', $userId);
        $stmt->execute();

        return $stmt->fetch()['number'];
    }
}