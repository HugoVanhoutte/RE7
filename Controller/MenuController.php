<?php

namespace App\Controller;

use App\Model\Entity\Menu;
use App\Model\Manager\Menu_RecipeManager;
use App\Model\Manager\MenuManager;

class MenuController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action'])
        {
            case 'new' :
            {
                $this->new();
                break;
            }

            case 'validateNew' :
            {
                $this->validateNew($_POST);
                break;
            }

            case 'view' :
            {
                $this->view($params['id']);
                break;
            }

            default:
            {
                $this->displayError(404);
                break;
            }
        }
    }

    private function new()
    {
        if (isset($_SESSION['user_id'])) {
            $this->display('menu/new', "Nouveau menu");
        } else {
            $this->display("user/login", "Connexion", [
                "error" => "Vous devez être connecté pour créer un menu."
            ]);
        }
    }

    private function validateNew($data)
    {
        $menuManager = new MenuManager();
        $menu = (new Menu())
            ->setName($data['name'])
            ->setAuthorId($_SESSION['user_id'])
            ;

        $id = $menuManager->insert($menu);

        //TODO Create menu_recipe for each data

        $recipes = [];

        foreach ($data as $key => $value) {
            if (str_contains($key, 'recipe')) {
                $recipeNumber = substr($key, strlen('recipe'));
                $recipes[$recipeNumber] = $value;
            }
        }

        $recipes = array_values($recipes);

        for ($i = 0; $i < count($recipes); $i++) {
            $data = [
                'menu_id' => $id,
                'recipe_id' => $recipes[$i]
            ];

            if (!empty($data['recipe_id'])) {
                (new Menu_RecipeManager())->insert($data);
            }
        }

        $this->display('menu/view', $menu->getName(), [
            'id' => $id
        ]);
    }

    private function view($id)
    {
        $menu = (new MenuManager())->get($id);
        $this->display('menu/view', $menu->getName(), [
            'id' => $id
        ]);
    }
}