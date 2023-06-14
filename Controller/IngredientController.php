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
        switch ($params['action']) {
            case 'getAll' :
            {
                $this->getAllAsJSON();
                break;
            }

            case 'new' :
            {
                $this->new();
                break;
            }

            case 'validateNew' :
            {
                $this->validateNew($_POST);
            }

            default :
            {
                $this->displayError(404);
            }
        }
    }

    /**
     * gets all ingredients from DB as a json for treatment in front
     * @return void
     */
    private function getAllAsJSON(): void
    {
        $this->getJson("getAllIngredients");

    }

    /**
     * displays ingredient creation page if user is authenticated, if not: sends to login page with error message
     * @return void
     */
    private function new(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->display("ingredient/new", "Ajouter un ingrédient");
        } else {
            $this->display("user/login", "Connexion", [
                "error" => "Afin d'ajouter un nouvel ingrédient, vous devez être connecté"
            ]);
        }
    }

    /**
     * validates and insert the newly created ingredient to the database by invoking insert() from manager
     * @param $data
     * @return void
     */
    private function validateNew($data): void
    {
        (new IngredientManager())->insert(strtolower($data['name']));
        $this->display("home/index", "Homepage", [
            "message" => "Votre ingrédient a été ajouté avec succès, vous pouvez maintenant créer une recette qui utilise ce dernier !"
        ]);
    }
}