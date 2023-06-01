<?php

namespace App\Controller;

use App\Model\Entity\Comment;
use App\Model\Entity\Recipe;
use App\Model\Manager\CommentManager;
use App\Model\Manager\RecipeManager;

class CommentController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action'])
        {
            case 'write' :
            {
                $this->write($params['recipe_id'], $_SESSION['user_id'], $_POST['content']);
                break;
            }

            case 'delete' :
            {
                $this->delete($params['id']);
                break;
            }

            default:
            {
                (new RootController())->displayError(404);
                break;
            }
        }
    }

    private function write($recipeId, $userId, $content) :void
    {
        $recipe = (new RecipeManager())->get($recipeId);
        /* @var Recipe $recipe */
        $comment = (new Comment())
            ->setRecipeId($recipeId)
            ->setAuthorId($userId)
            ->setContent($content)
            ;
        (new CommentManager())->insert($comment);
        header("location: ../../public/index.php/recipe?action=view&id=$recipeId");
        //$this->display('recipe/view', $recipe->getTitle(), ['id'=>$recipeId]);
    }

    private function delete($id)
    {
        $commentManager = new CommentManager();
        $comment = $commentManager->get($id);
        $recipeId = (new RecipeManager())->get($comment->getRecipeId())->getId();
        if ($commentManager->isEditable($comment->getAuthorId())){
            $commentManager->delete($id);
            header("location: ../../public/index.php/recipe?action=view&id=$recipeId");
        } else {
            $this->displayError(403);
        }
    }
}