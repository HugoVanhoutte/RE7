<?php

use App\Controller\RootController;
use App\Model\Entity\Recipe;
use App\Model\Manager\RecipeManager;

?>
<div class="container">
    <?php

    $recipeManager = new RecipeManager();
    $recipe = $recipeManager->get($params['id']);
    /* @var Recipe $recipe */

    if (!$recipeManager->isEditable($recipe->getAuthorId())) {
        (new RootController())->displayError(403);
        exit;
    } else {
        ?>

        <form action="../../public/index.php/recipe?action=validateEdit&id=<?= $recipe->getId() ?>" method="post">
            <div>
                <label for="title">Titre de la recette</label>
                <input type="text" maxlength="50" required name="title" id="title" value="<?= $recipe->getTitle() ?>">
            </div>

            <div>
                <label for="content">Contenu</label>
                <textarea name="content" id="content" cols="30" rows="10"><?= $recipe->getContent() ?></textarea>
            </div>

            <div>
                <label for="preparation_time_minutes">Temps de préparation (en minutes)</label>
                <input type="number" max="65535" name="preparation_time_minutes" id="preparation_time_minutes"
                       value="<?= $recipe->getPreparationTimeMinutes() ?>">
            </div>

            <div>
                <label for="cooking_time_minutes">Temps de cuisson (en minutes)</label>
                <input type="number" max="65535" name="cooking_time_minutes" id="cooking_time_minutes"
                       value="<?= $recipe->getCookingTimeMinutes() ?>">
            </div>

            <div>
                <input type="submit" value="&Eacute;diter ma recette">
            </div>
        </form>
        <?php
    }
    ?>
</div>
