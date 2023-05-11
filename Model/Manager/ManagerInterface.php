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

    /**
     * @param array $content
     * @return bool
     */
    public function insert(array $content): bool;

    /**
     * @param int $id
     * @param array $content
     * @return bool
     */
    public function update(int $id, array $content): bool;
}