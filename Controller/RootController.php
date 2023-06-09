<?php

namespace App\Controller;

require_once 'ControllerInterface.php';

class RootController extends AbstractController implements ControllerInterface
{
    /**
     * @inheritDoc
     * here: redirects to homepage
     */
    public function index(array $params = []): void
    {
        $this->display('home/index', 'Homepage');
    }
}