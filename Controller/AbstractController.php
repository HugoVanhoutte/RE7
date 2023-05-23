<?php

namespace App\Controller;

abstract class AbstractController
{
    /**
     * @param string $view
     * @param string $pageTitle
     * @param array $params
     * @return void
     */
    public function display(string $view, string $pageTitle, array $params = []): void
    {
        ob_start();
        require_once __DIR__ . "/../View/$view.php";
        $pageContent = ob_get_clean();

        require_once __DIR__ . "/../View/layout.php";
    }

    public function displayError(int $type): void
    {
        $this->display("error/$type", "Erreur $type");
    }
}