<?php

namespace App\Manager;

interface ManagerInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return array
     */
    public function get(int $id);

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}