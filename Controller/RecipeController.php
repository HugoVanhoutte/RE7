<?php

namespace App\Controller;

use App\Model\Entity\Recipe;
use App\Model\Manager\Recipe_IngredientManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

class RecipeController extends AbstractController implements ControllerInterface
{
    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action']) {
            case 'write' :
            {
                $this->write();
                break;
            }

            case 'validateWrite' :
            {
                $this->validateWrite($_POST);
                break;
            }

            case 'view' :
            {
                $this->view($params['id']);
                break;
            }

            case 'edit' :
            {
                $this->edit($params['id']);
                break;
            }

            case 'validateEdit' :
            {
                $this->validateEdit($_POST, $params['id']);
                break;
            }

            case 'delete' :
            {
                $this->delete($params['id']);
                break;
            }

            case 'getAll' :
            {
                $this->getAll();
                break;
            }

            default:
            {
                (new RootController())->index();
                break;
            }
        }
    }

    /**
     * redirects to recipe creation page if user authenticated, else: sends to login page with error message
     * @return void
     */
    private function write(): void
    {
        if ($_SESSION['user_id']) {
            $this->display('recipe/write', 'Nouvelle recette');
        } else {
            $this->display('user/login', 'Connexion', [
                'error' => 'Vous devez être connecté pour écrire une recette'
            ]);
        }
    }

    /**
     * validates new recipe and insert recipe and ingredients to DB
     * @param $data
     * @return void
     */
    private function validateWrite($data): void
    {
        //Instantiate a recipe manager, creates a new recipe object and gives it all dta needed
        $recipeManager = new RecipeManager();
        $recipe = (new Recipe())
            ->setTitle($data['title'])
            ->setContent($data['content'])
            ->setPreparationTimeMinutes($data['preparation_time_minutes'])
            ->setCookingTimeMinutes($data['cooking_time_minutes'])
            ->setAuthorId($_SESSION['user_id']);

        //Insert the recipe and gets newly added recipe id
        $id = $recipeManager->insert($recipe);

        /**
         * creates empty arrays for the ingredients, their associated units and quantities, as specified by user and
         * passed through Post method
         **/
        $ingredients = [];
        $quantities = [];
        $units = [];

        // gets every ingredients, units and quantities to add them to their respectives arrays
        foreach ($data as $key => $value) {
            if (str_contains($key, 'ingredient')) {
                $ingredientNumber = substr($key, strlen('ingredient'));
                $ingredients[$ingredientNumber] = $value;
            }
            if (str_contains($key, 'unit')) {
                $unitNumber = substr($key, strlen('unit'));
                $units[$unitNumber] = $value;
            }
            if (str_contains($key, 'quantity')) {
                $quantityNumber = substr($key, strlen('quantity'));
                $quantities[$quantityNumber] = $value;
            }
        }

        //Using array_values() to delete empty entries (avoid errors with missing keys)
        $ingredients = array_values($ingredients);
        $units = array_values($units);
        $quantities = array_values($quantities);

        //generates array with correctly formated data to insert into DB
        for ($i = 0; $i < count($ingredients); $i++) {
            $data = [
                'recipe_id' => $id,
                'ingredient_id' => $ingredients[$i],
                'unit_id' => $units[$i],
                'quantity' => $quantities[$i]
            ];

            if (!empty($data['ingredient_id'])) {
                (new Recipe_IngredientManager())->insert($data);
            }
        }

//Redirects to the newly created recipe
        $this->display('recipe/view', $recipe->getTitle(), [
            'id' => $id
        ]);
    }

    /**
     * redirects to a recipe page, if the recipe does bot exist: redirects to 404
     * @param $id
     * @return void
     */
    private function view($id): void
    {
        $recipe = (new RecipeManager())->get($id);
        if (is_null($recipe)) {
            $this->displayError(404);
            exit;
        }
        $this->display('recipe/view', $recipe->getTitle(), ['id' => $id]);
    }

    /**
     * redirects to edit page if user is authorised
     * @param $id
     * @return void
     */
    private function edit($id): void
    {
        $userManager = new UserManager();
        $recipe = (new RecipeManager())->get($id);
        /* @var Recipe $recipe */
        if (!$userManager->isAuthor($recipe->getAuthorId())) {
            $this->displayError(403);
        } else {
            $this->display('recipe/edit', 'Edition', ['id' => $id]);
        }
    }

    /**
     * validates and updates a recipe, and the recipe_ingredients (almost identical to creation of a new recipe)
     * @param $updateData
     * @param $id
     * @return void
     */
    private function validateEdit($updateData, $id): void
    {
        $recipeManager = new RecipeManager();
        $userManager = new UserManager();

        $recipe = $recipeManager->get($id);
        if ($userManager->isAuthor($recipe->getAuthorId())) {
            $recipeManager->update($id, $updateData);

            //Managing the ingredient/quantity/unit
            $ingredients = [];
            $quantities = [];
            $units = [];


            foreach ($updateData as $key => $value) {
                if (str_contains($key, 'ingredient')) {
                    $ingredientNumber = substr($key, strlen('ingredient'));
                    $ingredients[$ingredientNumber] = $value;
                }
                if (str_contains($key, 'unit')) {
                    $unitNumber = substr($key, strlen('unit'));
                    $units[$unitNumber] = $value;
                }
                if (str_contains($key, 'quantity')) {
                    $quantityNumber = substr($key, strlen('quantity'));
                    $quantities[$quantityNumber] = $value;
                }
            }

            $ingredients = array_values($ingredients);
            $units = array_values($units);
            $quantities = array_values($quantities);


            $recipeIngredientsManager = new Recipe_IngredientManager();

            $recipeIngredientsManager->deleteAllFromRecipe($id);
            $data = [];
            for ($i = 0; $i < count($ingredients); $i++) {
                if (isset($ingredients[$i])) {
                    $data = [
                        'recipe_id' => $id,
                        'ingredient_id' => $ingredients[$i],
                        'unit_id' => $units[$i],
                        'quantity' => $quantities[$i]
                    ];
                }
                if (!empty($data['ingredient_id'])) {
                    (new Recipe_IngredientManager())->insert($data);
                }
            }

            $this->view($id);

        } else {
            $this->displayError(403);
        }
    }

    /**
     * deletes a recipe if user is authorised
     * @param $id
     * @return void
     */
    private function delete($id): void
    {
        $recipeManager = new RecipeManager();
        $recipe = $recipeManager->get($id);
        if ((new UserManager())->isRemovable($recipe->getAuthorId())) {
            $recipeManager->delete($id);
            (new RootController())->index();
        } else {
            $this->displayError(403);
        }
    }


    /**
     * @return void
     * generates a JSON containing all recipes in DB
     */
    private function getAll(): void
    {
        $this->getJson("getAllRecipes");
    }
}