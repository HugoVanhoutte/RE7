<?php

namespace App\Controller;

use App\Model\Entity\Menu;
use App\Model\Manager\Menu_RecipeManager;
use App\Model\Manager\MenuManager;
use App\Model\Manager\UserManager;

class MenuController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action']) {
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

            case 'delete' :
            {
                $this->delete($params['id']);
                break;
            }

            default:
            {
                $this->displayError(404);
                break;
            }
        }
    }

    /**
     * displays menu creation page, if user is not authenticated: sends back to login page with error message
     * @return void
     */
    private function new(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->display('menu/new', "Nouveau menu");
        } else {
            $this->display("user/login", "Connexion", [
                "error" => "Vous devez être connecté pour créer un menu."
            ]);
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function validateNew($data): void
    {
        //Creates a new menu manager
        $menuManager = new MenuManager();
        //creates a new Menu Entity
        $menu = (new Menu())
            ->setName($data['name'])
            ->setAuthorId($_SESSION['user_id']);

        //Insert the new menu and gets its id in a variable
        $id = $menuManager->insert($menu);

        //Creates a new recipes empty array
        $recipes = [];

        //Gets every recipe's ids and puts them in the array
        foreach ($data as $key => $value) {
            if (str_contains($key, 'recipe')) {
                $recipeNumber = substr($key, strlen('recipe'));
                $recipes[$recipeNumber] = $value;
            }
        }

        //generates a new numeric array, in case a recipe was deleted and a new one added during creation
        $recipes = array_values($recipes);

        //iterates through the recipes array: generates the data as they will be inserted in DB: the menu id and the recipes id
        for ($i = 0; $i < count($recipes); $i++) {
            $data = [
                'menu_id' => $id,
                'recipe_id' => $recipes[$i]
            ];

            //Checks if an array entry is empty before trying to insert it
            if (!empty($data['recipe_id'])) {
                (new Menu_RecipeManager())->insert($data);
            }
        }

        //Redirects to the newly created menu page
        $this->display('menu/view', $menu->getName(), [
            'id' => $id
        ]);
    }

    /**
     * Displays a menu by its id, if menu does not exist: redirects to 404
     * @param $id
     * @return void
     */
    private function view($id): void
    {
        if (isset($_SESSION['user_id'])) {
            $menu = (new MenuManager())->get($id);
            if (is_null($menu)) {
                $this->displayError(404);
            }

            $this->display('menu/view', $menu->getName(), [
                'id' => $id
            ]);
        } else {
            $this->display("user/login", "Connexion", [
                'error' => 'Vous devez être connecté pour créer un menu'
                ]);
        }
    }

    /**
     * invokes delete method from manager if user is authorised, else displays error page
     * @param $id
     * @return void
     */
    private function delete($id): void
    {
        $menuManager = new MenuManager();
        $menuRecipeManager = new Menu_RecipeManager();
        $menu = $menuManager->get($id);
        /* @var Menu $menu */
        if ((new UserManager())->isRemovable($menu->getAuthorId())) {
            $menuManager->delete($id);
            $menuRecipeManager->deleteAllFromMenu($menu->getId());
            (new RootController())->index();
        } else {
            $this->displayError(403);
        }
    }
}