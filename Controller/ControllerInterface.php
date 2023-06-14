<?php

namespace App\Controller;

interface ControllerInterface
{
    /**
     * used with a switch, to redirect to the right method from parameters passed in URL
     * @param array $params
     * @return void
     */
    public function index(array $params = []): void;
}