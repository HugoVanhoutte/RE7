<?php

namespace App\Controller;

use App\Model\Entity\Ingredient;
use App\Model\Manager\CommentManager;
use App\Model\Manager\IngredientManager;

class IngredientController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action'])
        {
            case 'getAll' :
            {
            $this->getAllAsJSON();
            break;
            }

            default :
            {
                $this->displayError(404);
            }
        }
    }

    private function getAllAsJSON()
    {
        $this->getJson("test");

    }
}