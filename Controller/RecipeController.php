<?php

namespace App\Controller;

use App\Model\Entity\Recipe;
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
            case 'write' : {
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

            default:
            {
                (new RootController())->index();
                break;
            }
        }
    }

    /**
     * @return void
     */
    private function write():void
    {
        $this->display('recipe/write','Nouvelle recette');
    }

    /**
     * @param $data
     * @return void
     */
    private function validateWrite($data):void {
        $recipeManager = new RecipeManager();
        $recipe = (new Recipe())
            ->setTitle($recipeManager->sanitize($data['title']))
            ->setContent($recipeManager->sanitize($data['content']))
            ->setPreparationTimeMinutes($recipeManager->sanitize($data['preparation_time_minutes']))
            ->setCookingTimeMinutes($recipeManager->sanitize($data['cooking_time_minutes']))
            ->setAuthorId($recipeManager->sanitize($_SESSION['user_id']))
            ;

        $id = $recipeManager->insert($recipe);

        $this->display('recipe/view', 'Recette', [
            'id' => $id
        ]);
    }

    /**
     * @param $id
     * @return void
     */
    private function view($id): void
    {
        $recipe = (new RecipeManager())->get($id);
        if (is_null($recipe)){
            $this->displayError(404);
            exit;
        }

        $this->display('recipe/view', $recipe->getTitle(), ['id' => $id]);
    }

    /**
     * @param $id
     * @return void
     */
    private function edit($id):void
    {
        $this->display('recipe/edit', 'Edition', ['id'=>$id]);
    }

    /**
     * @param $updateData
     * @param $id
     * @return void
     */
    private function validateEdit($updateData, $id): void
    {
        $recipeManager = new RecipeManager();
        $userManager = new UserManager();

        $recipe = $recipeManager->get($id);
        if($userManager->isAuthor($recipe->getAuthorId())) {
            $recipeManager->update($id, $updateData);
            $this->view($id);
        } else {
            $this->displayError(403);
        }
    }

    /**
     * @param $id
     * @return void
     */
    private function delete($id): void
    {
        $recipeManager = new RecipeManager();
        $recipe = $recipeManager->get($id);
        if((new UserManager())->isAuthor($recipe->getAuthorId())) {
            $recipeManager->delete($id);
            (new RootController())->index();
        } else {
            $this->displayError(403);
        }
    }
}