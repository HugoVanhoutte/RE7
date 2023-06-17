<?php

namespace App\Controller;

abstract class AbstractController
{
    /**
     * displays a view, with a specified title and parameters
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

    /**
     * displays an error page, specified by its HTTP error code
     * @param int $type
     * @return void
     */
    public function displayError(int $type): void
    {
        $this->display("error/$type", "Erreur $type");
    }

    /**
     * redirects to a generated json
     * @param string $file
     * @return void
     */
    public function getJson(string $file): void
    {
        require_once __DIR__ . "/../json/$file.php";
    }
}