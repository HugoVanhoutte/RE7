<?php

use App\Model\Entity\Recipe;
use App\Model\Entity\User;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UserManager;

?>
<div class="container">
    <?php
//Checks if user is authenticated, if he is: get his infos from DB, else: set his username to "guest"
    if (isset($_SESSION['user_id'])) {
        $user = (new UserManager())->get($_SESSION['user_id']);
    } else {
        $user = (new User())->setUsername("invité");
    }
    ?>


    <h1>Bienvenue <strong><?= $user->getUsername() ?></strong></h1>

    <div>
        <p>Le site RE7 vous propose de créer et partager des recettes avec d'autres personnes</p>
    </div>

    <h2>Les recettes les plus récentes: </h2>
    <section class="container">
        <div class="row align-items-center justify-content-center">
            <?php
            //Gets 3 most recent recipes to display on homepage: TODO Change for X most liked recipes when likes implemented
            foreach ((new RecipeManager())->getXMostRecent(3) as $recipe) {
                /* @var Recipe $recipe */
                $author = (new UserManager)->get($recipe->getAuthorId());
                ?>
                <div class="col-8 col-lg-4 col-xl-3">
                    <div class="card bg-light rounded shadow m-2 text-center border-0">
                        <a href="/index.php/recipe?action=view&id=<?= $recipe->getId() ?>" class="card-title display-6 text-decoration-none"><?= $recipe->getTitle() ?></a>
                        <a href="/index.php/user?action=profile&id=<?= $author->getId() ?>" class="text-muted"><?= $author->getUsername() ?></a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</div>