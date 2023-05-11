<?php

namespace App\Manager;

interface ManagerInterface
{
    public function getAll(): array;
    public function get(int $id): array;
    public function delete(int $id): bool;
    public function insert(array $content): bool;
    public function update(int $id, array $content): bool;
}