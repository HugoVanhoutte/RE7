<?php

namespace App\Controller;

class RecipeController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action']) {
            case 'write' : {
                $this->write();
            }

            default:
            {
                (new RootController())->index();
            }
        }
    }

    private function write()
    {
        $this->display('recipe/write','Nouvelle recette');
    }
}