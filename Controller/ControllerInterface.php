<?php

namespace App\Controller;

interface ControllerInterface
{
    /**
     * @param array $params
     * @return void
     */
    public function index(array $params = []): void;
}