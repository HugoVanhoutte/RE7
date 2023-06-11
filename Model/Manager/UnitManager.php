<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Unit;

class UnitManager extends AbstractManager implements ManagerInterface
{

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM units";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $units = [];
        foreach ($stmt->fetchAll() as $unitData)
        {
            $units[] = (new Unit())
                ->setId($unitData['id'])
                ->setName($unitData['name'])
                ;
        }
        return $units;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?object
    {
        $sql = "SELECT * FROM units WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();
        return (new Unit())
            ->setId($data['id'])
            ->setName($data['name'])
            ;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM units WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $updateData = []): bool
    {
        $sql = "UPDATE units SET name = :name WHERE id = :id ";
        $stmt = DB::getInstance()->prepare($sql);

        $name = $this->sanitize($updateData['name']);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);

        return $stmt-> execute();
    }

    public function insert(string $name): int
    {
        $sql = "INSERT INTO units (name)
                VALUES (:name)";
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        $name = $this->sanitize($name);

        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $pdo->lastInsertId();
    }
}