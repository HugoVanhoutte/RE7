<?php

use App\Controller\RootController;
use App\Model\Entity\Recipe;
use App\Model\Manager\RecipeManager;

?>
<?php

$recipeManager = new RecipeManager();
$recipe = $recipeManager->get($params['id']);
/* @var Recipe $recipe */

if (!$recipeManager->isAuthor($recipe->getAuthorId())) {
    (new RootController())->displayError(403);
    exit;
} else {
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 shadow rounded bg-light text-center">
                <form action="../../public/index.php/recipe?action=validateEdit&id=<?= $recipe->getId() ?>"
                      method="post">
                    <div class="my-2">
                        <label for="title" class="form-label">Titre de la recette</label>
                        <input type="text" maxlength="50" required name="title" id="title"
                               value="<?= $recipe->getTitle() ?>" class="form-control">
                    </div>

                    <div class="my-2">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea name="content" id="content" cols="30"
                                  rows="10" class="form-control"><?= $recipe->getContent() ?></textarea>
                    </div>

                    <div class="my-2">
                        <label for="preparation_time_minutes" class="form-label">Temps de préparation (en minutes)</label>
                        <input type="number" max="65535" name="preparation_time_minutes" id="preparation_time_minutes"
                               value="<?= $recipe->getPreparationTimeMinutes() ?>" class="form-control">
                    </div>

                    <div class="my-2">
                        <label for="cooking_time_minutes" class="form-label">Temps de cuisson (en minutes)</label>
                        <input type="number" max="65535" name="cooking_time_minutes" id="cooking_time_minutes" class="form-control"
                               value="<?= $recipe->getCookingTimeMinutes() ?>">
                    </div>

                    <div class="my-3">
                        <input type="submit" value="&Eacute;diter ma recette" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>
