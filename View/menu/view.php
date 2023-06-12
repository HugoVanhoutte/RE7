<?php

use App\Model\Entity\Menu;
use App\Model\Entity\Recipe;
use App\Model\Manager\Menu_RecipeManager;
use App\Model\Manager\MenuManager;
use App\Model\Manager\RecipeManager;

$menuManager = new MenuManager();
$menu = $menuManager->get($params['id']);
/* @var Menu $menu */
$recipeManager = new RecipeManager();
$menu_RecipeManager = new Menu_RecipeManager();
?>


<h1>Menu: <?= $menu->getName() ?></h1>
<?php
foreach ($menu_RecipeManager->getFromMenu($menu->getId()) as $recipe)
{
    $recipeObject = $recipeManager->get($recipe['recipe_id']);
    /* @var Recipe $recipeObject */
    ?>
    <a href="/index.php/recipe?action=view&id=<?= $recipeObject->getId() ?>"><?= $recipeObject->getTitle() ?></a>
<?php
}

//TODO, Display cards