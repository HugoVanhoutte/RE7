<?php
//TODO GET RECIPE INFOS FROM $params['id']
use App\Model\Entity\Comment;
use App\Model\Entity\Recipe;
use App\Model\Manager\CommentManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

$recipeManager = new RecipeManager();
$recipe = $recipeManager->get($params['id']);
/* @var Recipe $recipe */
$userManager = new UserManager();
$author = $userManager->get($recipe->getAuthorId());
if (isset($_SESSION['user_id']) && $recipeManager->isEditable($recipe->getAuthorId())) {
    ?>
        <div>
            <a href="../../public/index.php/recipe?action=edit&id=<?= $recipe->getId() ?>" title="&Eacute;diter la recette"><i class="fa-solid fa-pen"></i></a>
            <a href="../../public/index.php/recipe?action=delete&id=<?= $recipe->getId() ?>" title="Supprimer la recette"><i class="fa-solid fa-trash"></i></a>
        </div>
            <?php
}
?>

<h1><?= $recipe->getTitle() ?></h1>

<div>
    <h2>Temps de préparation: <?= $recipe->getPreparationTimeMinutes() ?> minutes</h2>
    <h2>Temps de cuisson: <?= $recipe->getCookingTimeMinutes() ?> minutes</h2>
</div>

<p><?= $recipe->getContent() ?></p>

<h3>Recette Créée par <strong><a
                href="../../public/index.php/user?action=profile&id=<?= $author->getId() ?>"><?= $author->getUsername() ?></a></strong>
    le <?= $recipeManager->getTimeFR($recipe->getCreationDateTime()) ?></h3>

<div>
    <h2>Commentaires: </h2>

    <div>
        <?php
        if (isset($_SESSION['user_id'])) {
        ?>
        <form action="../../public/index.php/comment?action=write&recipe_id=<?= $recipe->getId() ?>" method="post">
            <label for="content">&Eacute;crire un commentaire</label>
            <input type="text" name="content" id="content" maxlength="150">
            <input type="submit" value="Commenter">
        </form>
    </div>
    <?php
    }
        $commentManager = new CommentManager();
        $comments = $commentManager->getCommentsByRecipeId($recipe->getId());
    foreach ($comments as $comment) {
            /* @var Comment $comment */
        $author = $userManager->get($comment->getAuthorId())
        ?>
        <div>

            <p><?= $comment->getContent() ?></p>
            <p>&Eacute;crit par <?= $author->getUsername() ?> le <?= $commentManager->getTimeFR($comment->getCreationDateTime()) ?></p><?php
            if ($commentManager->isEditable($comment->getAuthorId())) {
                ?>
                <a href="../../public/index.php/comment?action=delete&id=<?= $comment->getId() ?>" title="Supprimer ce commentaire"><i class="fa-solid fa-trash"></i></a>
                <?php
            }
            ?>
        </div>
    <?php
        }
    ?>
</div>