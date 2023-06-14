<?php

namespace App\Controller;

use App\Model\Entity\Comment;
use App\Model\Entity\Recipe;
use App\Model\Manager\CommentManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

class CommentController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action']) {
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

    /**
     * invokes insert method from manager, with specified parameters if the user is authenticated, if not, sends back to
     * login page with error message
     * @param $recipeId
     * @param $userId
     * @param $content
     * @return void
     */
    private function write($recipeId, $userId, $content): void
    {
        if (isset($_SESSION['user_id'])) {
            $recipe = (new RecipeManager())->get($recipeId);
            /* @var Recipe $recipe */
            $comment = (new Comment())
                ->setRecipeId($recipeId)
                ->setAuthorId($userId)
                ->setContent($content);
            (new CommentManager())->insert($comment);
            //FIXME link
            header("location: /index.php/recipe?action=view&id=$recipeId");
            //$this->display('recipe/view', $recipe->getTitle(), ['id'=>$recipeId]);
        } else {
            $this->display('user/login', 'Connexion', [
                'error' => 'Pour commenter, vous devez être connecté'
            ]);
        }
    }

    /**
     * invoke delete method from manager if user is authorised, else, sends to error page 403 (unauthorised access)
     * @param $id
     * @return void
     */
    private function delete($id): void
    {
        $commentManager = new CommentManager();
        $comment = $commentManager->get($id);
        $recipeId = (new RecipeManager())->get($comment->getRecipeId())->getId();
        if ((new UserManager())->isRemovable($comment->getAuthorId())) {
            $commentManager->delete($id);
            //FIXME Link
            header("location: /index.php/recipe?action=view&id=$recipeId");
        } else {
            $this->displayError(403);
        }
    }
}