<?php

use App\Model\Entity\Menu;
use App\Model\Entity\Recipe;
use App\Model\Entity\User;
use App\Model\Manager\Menu_RecipeManager;
use App\Model\Manager\MenuManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

$menuManager = new MenuManager();
$menu = $menuManager->get($params['id']);
/* @var Menu $menu */
$recipeManager = new RecipeManager();
$menu_RecipeManager = new Menu_RecipeManager();
$userManager = new UserManager();
$author = $userManager->get($menu->getAuthorId());
/* @var User $author */
?>
<div class="container">
<?php

//Checking if current user has removing authorisations (admin OR author), if true displays recipe delete button
if ($userManager->isRemovable($author->getId())) {
    ?>
    <a href="/index.php/menu?action=delete&id=<?= $menu->getId() ?>"
       title="Supprimer la recette" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
    <?php
}
?>

<h1>Menu: <?= $menu->getName() ?></h1>
<div class="row">
<?php
foreach ($menu_RecipeManager->getFromMenu($menu->getId()) as $recipe)
//Displays each recipe as a card
{
$recipe = $recipeManager->get($recipe['recipe_id']);
/* @var Recipe $recipe */
?>
<div class="col-12 col-md-5 col-lg-4 col-xl-3">
    <div class="card bg-light rounded shadow m-2 text-center border-0">
        <a href="/index.php/recipe?action=view&id=<?= $recipe->getId() ?>"
           class="card-title display-6 text-decoration-none"><?= $recipe->getTitle() ?></a>
        <p class="text-muted fst-italic">
            le <?= $recipeManager->getTimeFR($recipe->getCreationDateTime()) ?></p>
        <?php
        //Get recipes authors: enable or not edition and removing capabilities
        $recipeAuthor = $userManager->get($recipe->getAuthorId());
        if ($userManager->isAuthor($recipeAuthor->getId())) {
            ?>
            <a href="/index.php/recipe?action=edit&id=<?= $recipe->getId() ?>"
               title="&Eacute;diter" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
            <?php
        }
        if ($userManager->isRemovable($recipeAuthor->getId())) {
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
</div>
