<?php

use App\Model\Entity\Comment;
use App\Model\Entity\Recipe;
use App\Model\Entity\User;
use App\Model\Manager\CommentManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

?>
<div class="container">
    <?php
//Getting all instances and managers
    $recipeManager = new RecipeManager();
    $recipe = $recipeManager->get($params['id']);
    /* @var Recipe $recipe */
    $userManager = new UserManager();
    $author = $userManager->get($recipe->getAuthorId());
    /* @var User $author */

    //Checking if current user is recipe author, if true displays recipe editing button
    if ($userManager->isAuthor($recipe->getAuthorId())) {
        ?>
        <a href="../../public/index.php/recipe?action=edit&id=<?= $recipe->getId() ?>"
           title="&Eacute;diter la recette" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
        <?php
    }
    //Checking if current user has removing authorisations (admin OR author), if true displays recipe delete button
    if ($userManager->isRemovable($author->getId())) {
        ?>
        <a href="../../public/index.php/recipe?action=delete&id=<?= $recipe->getId() ?>"
           title="Supprimer la recette" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
        <?php
    }
    ?>

    <div> <!--RECIPE: Displays content xritten by user from DB: since user entry is sanitized: need to use htmlspecialchars_decode for proper display and nl2br for new lines-->
        <h1><?= nl2br(htmlspecialchars_decode($recipe->getTitle())) ?></h1>

        <div>
            <h2>Temps de préparation: <?= $recipe->getPreparationTimeMinutes() ?> minutes</h2>
            <h2>Temps de cuisson: <?= $recipe->getCookingTimeMinutes() ?> minutes</h2>
        </div>

        <p><?= nl2br(htmlspecialchars_decode($recipe->getContent())) ?></p>

        <h3>Recette Créée par <strong><a
                        href="../../public/index.php/user?action=profile&id=<?= $author->getId() ?>"><?= $author->getUsername() ?></a></strong>
            le <?= $recipeManager->getTimeFR($recipe->getCreationDateTime()) ?></h3>

    </div>

    <div>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-8 col-xl-6 col-xxl-4 border rounded">
                <h2>Commentaires: </h2>

                <?php
                //Checks if user is authenticated, if true: displays new comment form
                if (isset($_SESSION['user_id'])) {
                ?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col col-md-8 shadow rounded bg-light text-center">
                            <form action="../../public/index.php/comment?action=write&recipe_id=<?= $recipe->getId() ?>"
                                  method="post">
                                <div class="my-2">
                                    <label for="content" class="form-label">&Eacute;crire un commentaire</label>
                                    <input type="text" name="content" id="content" maxlength="150"
                                           placeholder="Votre commentaire" class="form-control">
                                </div>
                                <div class="my-3">
                                    <input type="submit" value="Commenter" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <ul class="list-unstyled">
                    <?php
                    }
                    $commentManager = new CommentManager();
                    $comments = $commentManager->getCommentsByRecipeId($recipe->getId());
                    foreach ($comments as $comment) {
                        /* @var Comment $comment */
                        $author = $userManager->get($comment->getAuthorId())
                        ?>
                        <li class="bg-light rounded shadow m-3 p-2">
                            <p><?= $comment->getContent() ?></p>
                            <p class="text-muted fst-italic">&Eacute;crit par <a
                                        href="../../public/index.php/user?action=profile&id=<?= $author->getId() ?>"><?= $author->getUsername() ?></a>
                                le <?= $commentManager->getTimeFR($comment->getCreationDateTime()) ?></p><?php
                            if ($userManager->isRemovable($comment->getAuthorId())) {
                                ?>
                                <div>
                                    <a href="../../public/index.php/comment?action=delete&id=<?= $comment->getId() ?>"
                                       title="Supprimer ce commentaire"><i class="fa-solid fa-trash"></i></a>
                                </div>
                                <?php
                            }
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>