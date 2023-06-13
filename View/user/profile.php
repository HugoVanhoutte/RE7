<?php

use App\Model\Entity\Comment;
use App\Model\Entity\Menu;
use App\Model\Entity\Recipe;
use App\Model\Manager\CommentManager;
use App\Model\Manager\MenuManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\RoleManager;
use App\Model\Entity\User;
use App\Model\Manager\UserManager;

$user = $params['user'];
$userManager = new UserManager();

/* @var User $user */
?>
<div class="container">
    <?php
    if ($userManager->isAuthor($user->getId())) //Checks if user is authenticated (prevent error message) and check if he is admin or user
    {
        ?>
        <a href="/index.php/user?action=edit&id=<?= $user->getId() ?>" title="&Eacute;diter mon profil"
           class="btn btn-outline-primary">
            <i class="fa-solid fa-pen"></i></a>
        <?php
    }
    if ($userManager->isRemovable($user->getId())) {
        ?>
        <a href="/index.php/user?action=delete&id=<?= $user->getId() ?>" title="Supprimer mon compte"
           class="btn btn-outline-danger">
            <i class="fa-solid fa-trash"></i></a>
        <?php
    }
    ?>
<div> <!-- Profile -->
    <h1>Profil de <?= $user->getUsername() ?></h1>
    <p><strong>Adresse Mail:</strong> <?= $user->getEmail() ?></p>
    <p><strong>Rôle: </strong><?= (new RoleManager())->getRole($user->getRoleId()) ?></p>
    <p><strong>Compte créé le </strong><?= (new UserManager())->getTimeFR($user->getRegistrationDateTime()) ?></p>
</div>
<?php
$recipeManager = new RecipeManager();
?>
<h2>Liste des recettes de <?= $user->getUsername() ?> <span class="badge bg-secondary"><?= $recipeManager->getNumberRecipePerUser($user->getId()) ?></span></h2>
<section class="container">
    <div class="row align-items-center justify-content-center">
        <?php
        $recipes = $recipeManager->getRecipesByAuthorId($user->getId());

        if (empty($recipes)) {
            ?>
            <p class="text-muted"><?= $user->getUsername() ?> n'a pas encore publié de recettes</p>
            <?php
        }
        foreach ($recipes as $recipe) {
            /* @var Recipe $recipe */
            ?>
            <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                <div class="card bg-light rounded shadow m-2 text-center border-0">
                    <a href="/index.php/recipe?action=view&id=<?= $recipe->getId() ?>"
                       class="card-title display-6 text-decoration-none"><?= $recipe->getTitle() ?></a>
                    <p class="text-muted fst-italic">
                        le <?= $recipeManager->getTimeFR($recipe->getCreationDateTime()) ?></p>
                    <?php
                    if ($userManager->isAuthor($user->getId())) {
                        ?>
                        <a href="/index.php/recipe?action=edit&id=<?= $recipe->getId() ?>"
                           title="&Eacute;diter" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                        <?php
                    }
                    if ($userManager->isRemovable($user->getId())) {
                        ?>
                        <a href="/index.php/recipe?action=delete&id=<?= $recipe->getId() ?>"
                           title="Supprimer" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>

    <?php
    $menuManager = new MenuManager();
    ?>
    <h2>Liste des menus de <?= $user->getUsername() ?> <span class="badge bg-secondary"><?= $menuManager->getNumberMenusPerUser($user->getId()) ?></span></h2>
    <section class="container">
        <div class="row align-items-center justify-content-center">
            <?php
                $menus = $menuManager->getMenusByAuthorId($user->getId());
            if (empty($menus)) {
            ?>
            <p class="text-muted"><?= $user->getUsername() ?> n'a pas encore publié de recettes</p>
            <?php
        }
            foreach ($menus as $menu) {
                /* @var Menu $menu */
                ?>
                <div class="col-12 col-md-5 col-md-5 col-lg-4 col-xl-3">
                    <div class="card bg-light rounded shadow m-2 text-center border-0">
                        <a href="/index.php/menu?action=view&id=<?= $menu->getId() ?>"
                           class="card-title display-6 text-decoration-none"><?= $menu->getName() ?></a>
                        <?php
                        if ($userManager->isRemovable($user->getId())) {
                            ?>
                            <a href="/index.php/menu?action=delete&id=<?= $menu->getId() ?>"
                               title="Supprimer" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>



<?php
$commentManager = new CommentManager();
?>
<h2>Liste des commentaires de <?= $user->getUsername() ?> <span class="badge bg-secondary"><?= $commentManager->getNumberCommentsPerUser($user->getId()) ?></span></h2>
<section class="container">
    <div class="row align-items-center justify-content-center">
        <?php
        $comments = $commentManager->getCommentsByAuthorId($user->getId());

        if (empty($comments)) {
            ?>
            <p class="text-muted"><?= $user->getUsername() ?> n'a pas encore publié de commentaires</p>
            <?php
        }

        foreach ($comments as $comment) {
            /* @var Comment $comment */
            $recipe = $recipeManager->get($comment->getRecipeId())
            ?>

            <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                <div class="card bg-light rounded shadow m-2 text-center border-0">
                    <p class="lead"><?= $comment->getContent() ?></p>
                    <p class="text-muted fst-italic">
                        le <?= $commentManager->getTimeFR($comment->getCreationDateTime()) ?> à propos de <a
                                href="/index.php/recipe?action=view&id=<?= $recipe->getId() ?>"><?= $recipe->getTitle() ?></a>
                    </p>
                    <?php
                    if (isset($_SESSION['user_id']) && (new UserManager())->isRemovable($user->getId())) {
                        ?>
                        <a href="/index.php/comment?action=delete&id=<?= $comment->getId() ?>"
                           title="Supprimer" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>
</div>