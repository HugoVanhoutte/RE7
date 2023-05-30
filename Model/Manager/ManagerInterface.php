<?php

namespace App\Model\Manager;

interface ManagerInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return object|null
     */
    public function get(int $id): ?object;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $id
     * @param array $updateData
     * @return bool
     */
    public function update(int $id, array $updateData): bool;
}