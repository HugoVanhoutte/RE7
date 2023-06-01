<?php
$user = $params['user'];
    /* @var User $user */

use App\Model\Entity\Comment;
use App\Model\Entity\Recipe;
use App\Model\Manager\CommentManager;
use App\Model\Manager\RecipeManager;use App\Model\Manager\RoleManager;
use App\Model\Entity\User;
use App\Model\Manager\UserManager;
if (isset($_SESSION['user_id']) && (new UserManager())->isEditable($user->getId())) //Checks if user is authenticated (prevent error message) and check if he is admin or user
{
    ?>
        <div class="admin">
            <a href="../index.php/user?action=edit&id=<?= $user->getId() ?>" title="&Eacute;diter mon profil"><i class="fa-solid fa-pen"></i></a>
            <a href="../index.php/user?action=delete&id=<?= $user->getId() ?>" title="Supprimer mon compte"><i class="fa-solid fa-trash"></i></a>
        </div>
            <?php
}
?>
<div class="profile">
    <h1>Profil de <?= $user->getUsername() ?></h1>
    <p><strong>Adresse Mail:</strong> <?= $user->getEmail() ?></p>
    <p><strong>Rôle: </strong><?= (new RoleManager())->getRole($user->getRoleId()) ?></p>
    <p><strong>Compte créé le </strong><?= (new UserManager())->getTimeFR($user->getRegistrationDateTime()) ?></p>
</div>
    <h2>Liste des recettes de <?= $user->getUsername() ?></h2>
<ul class="recipes-section">
    <?php
    $recipeManager = new RecipeManager();
    $recipes = $recipeManager->getRecipesByAuthorId($user->getId());

    if (empty($recipes)){
    ?>
    <h3 class="credits"><?= $user->getUsername() ?> n'a pas encore publié de recettes</h3>
    <?php
    }
    foreach ($recipes as $recipe) {
        /* @var Recipe $recipe */
        ?>
        <li class="recipe"><a href="../../public/index.php/recipe?action=view&id=<?= $recipe->getId() ?>"><?= $recipe->getTitle() ?></a>
            <p class="credits">le <?= $recipeManager->getTimeFR($recipe->getCreationDateTime()) ?></p>
            <?php
            if (isset($_SESSION['user_id']) && (new UserManager())->isEditable($user->getId())) {
            ?>
                    <div class="admin">
                        <a href="../../public/index.php/recipe?action=edit&id=<?= $recipe->getId() ?>" title="&Eacute;diter"><i class="fa-solid fa-pen"></i></a>
                        <a href="../../public/index.php/recipe?action=delete&id=<?= $recipe->getId() ?>" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                    </div>
            <?php
            }
            ?>
            </li>
    <?php
    }
    ?>
</ul>
<h2>Liste des commentaires de <?= $user->getUsername() ?></h2>
<ul class="comment-section">
    <?php
    $commentManager = new CommentManager();
    $comments = $commentManager->getCommentsByAuthorId($user->getId());

    if (empty($comments)) {
        ?>
            <h3 class="credits"><?= $user->getUsername() ?> n'a pas encore publié de commentaires</h3>
            <?php
    }

    foreach ($comments as $comment) {
        /* @var Comment $comment */
        $recipe = $recipeManager->get($comment->getRecipeId())
        ?>
        <li class="comment">
            <h3><?= $comment->getContent() ?></h3>
            <p class="credits">le <?= $commentManager->getTimeFR($comment->getCreationDateTime()) ?> à propos de <a
                        href="../../public/index.php/recipe?action=view&id=<?= $recipe->getId() ?>"><?= $recipe->getTitle() ?></a></p>
            <?php
            if (isset($_SESSION['user_id']) && (new UserManager())->isEditable($user->getId())) {
                ?>
                <div class="admin">
                    <a href="../../public/index.php/comment?action=edit&id=<?= $comment->getId() ?>" title="&Eacute;diter"><i class="fa-solid fa-pen"></i></a>
                    <a href="../../public/index.php/comment?action=delete&id=<?= $comment->getId() ?>" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                </div>
                <?php
            }
            ?>
        </li>
    <?php
    }
    ?>

</ul>