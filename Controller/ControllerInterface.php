<?php

namespace App\Controller;

interface ControllerInterface
{
    public function index(string $action, array $params = []); //TODO Add pageTitle here or to each action ?
}