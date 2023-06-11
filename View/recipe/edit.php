<?php

use App\Controller\RootController;
use App\Model\Entity\Ingredient;
use App\Model\Entity\Recipe;
use App\Model\Entity\Unit;
use App\Model\Manager\IngredientManager;
use App\Model\Manager\Recipe_IngredientManager;
use App\Model\Manager\RecipeManager;
use App\Model\Manager\UnitManager;
use App\Model\Manager\UserManager;

$recipeManager = new RecipeManager();
$recipe = $recipeManager->get($params['id']);
/* @var Recipe $recipe */
$userManager = new UserManager();

if (!$userManager->isAuthor($recipe->getAuthorId())) {
    (new RootController())->displayError(403);
    exit;
} else {
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 shadow rounded bg-light text-center">
                <form action="/recipe?action=validateEdit&id=<?= $recipe->getId() ?>"
                      method="post" class="needs-validation">
                    <div class="my-2">
                        <label for="title" class="form-label">Titre de la recette</label>
                        <input type="text" maxlength="50" required name="title" id="title"
                               value="<?= $recipe->getTitle() ?>" class="form-control">
                    </div>

                    <div class="shadow rounded bg-light text-center" id="ingredients">
                        <?php

                        $ingredientManager = new IngredientManager();
                        $unitManager = new UnitManager();
                        $recipe_IngredientManager = new Recipe_IngredientManager();

                        $number = 1;
                        foreach ($recipe_IngredientManager->getFromRecipe($recipe->getId()) as $ingredient)
                        /* @var Ingredient $ingredient */
                        {

                            $ingredients = $ingredientManager->getAll();
                            ?>
                                <div class="ingredientLine">
                            <select name="ingredient<?= $number ?>" id="ingredient<?= $number ?>">
                                <?php
                                foreach($ingredients as $ingredientEntity){
                                    /* @var Ingredient $ingredientEntity */
                                    ?>
                                    <option <?php if ($ingredient['ingredient_id'] === $ingredientEntity->getId()) {echo "selected";} ?> value="<?= $ingredientEntity->getId() ?>"><?= $ingredientEntity->getName() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <input type="number" name="quantity<?= $number ?>" id="quantity<?= $number ?>" value="<?= $ingredient['quantity'] ?>">
                            <select name="unit<?= $number ?>" id="unit<?= $number ?>">
                                <?php
                                $units = $unitManager->getAll();
                                foreach($units as $unit){
                                    /* @var Unit $unit */
                                    ?>
                                    <option <?php if ($ingredient['unit_id'] === $unit->getId()) {echo "selected";} ?> value="<?= $unit->getId() ?>"><?= $unit->getName() ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                                </div>
                        <?php
                            $number++;
                        }
                        ?>

                        <button id="addIngredientButton" type="button">Ajouter un ingrédient</button>
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
    <script defer src="/assets/addIngredient.js"></script>
    <?php
}
?>
