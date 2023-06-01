<?php

use App\Model\Entity\Recipe;
use App\Model\Entity\User;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

if (isset($_SESSION['user_id'])) {
    $user = (new UserManager())->get($_SESSION['user_id']);
} else $user = (new User())->setUsername("invité")
?>


<h1>Bienvenue <strong><?= $user->getUsername() ?></strong></h1>

<div>
    <p>Le site RE7 vous propose de créer et partager des recettes avec d'autres personnes</p>
</div>

<h2>Les recettes les plus récentes: </h2>
<ul>
    <?php
    foreach ((new RecipeManager())->getAllDesc() as $recipe) {
        /* @var Recipe $recipe */
        $author = (new UserManager)->get($recipe->getAuthorId());
        ?>
        <li><a href="../public/index.php/recipe?action=view&id=<?= $recipe->getId() ?>"><strong><?= $recipe->getTitle() ?></strong></a> par
            <a href="../public/index.php/user?action=profile&id=<?= $author->getId() ?>"><?= $author->getUsername() ?></a></li>
        <?php
    }
    ?>
</ul>