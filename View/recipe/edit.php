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

//Get recipe Author and check if current user is author, if he is not: redirects to error 403
if (!$userManager->isAuthor($recipe->getAuthorId())) {
    (new RootController())->displayError(403);
    exit;
} else {
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 shadow rounded bg-light text-center">
                <form action="/recipe?action=validateEdit&id=<?= $recipe->getId() ?>"
                      method="post">
                    <div class="my-2">
                        <label for="title" class="form-label">Titre de la recette</label>
                        <input type="text" maxlength="50" required name="title" id="title"
                               value="<?= $recipe->getTitle() ?>" class="form-control">
                    </div>

                    <div class="my-2" id="ingredients"> <!--Ingredients container-->
                        <div class="row justify-content-center">
                            <div class="col-4"><h5>ingrédient</h5></div>
                            <div class="col-2"><h5>Quantité</h5></div>
                            <div class="col-4"><h5>Unité</h5></div>
                            <div class="col-1"></div>
                        </div>
                        <?php

                        /*
                         * Creates managers and entities used in the recipe, so that they are placed in the correct inputs/selects and option
                         * For recipe edition
                         */

                        $ingredientManager = new IngredientManager();
                        $unitManager = new UnitManager();
                        $recipe_IngredientManager = new Recipe_IngredientManager();

                        $number = 1;
                        foreach ($recipe_IngredientManager->getFromRecipe($recipe->getId()) as $ingredient) {
                            /* @var Ingredient $ingredient */
                            $ingredients = $ingredientManager->getAll();
                            ?>
                            <div class="ingredientLine row justify-content-center my-2">
                                <div class="col-4"> <!--Ingredient div-->
                                    <select name="ingredient<?= $number ?>" id="ingredient<?= $number ?>" class="form-select"> <!--ingredient select-->
                                        <?php
                                        foreach ($ingredients as $ingredientEntity) {
                                            /* @var Ingredient $ingredientEntity */
                                            ?>
                                            <option <?php if ($ingredient['ingredient_id'] === $ingredientEntity->getId()) {
                                                echo "selected";
                                            } ?> value="<?= $ingredientEntity->getId() ?>"><?= $ingredientEntity->getName() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2"> <!--quantity div-->
                                    <input type="number" name="quantity<?= $number ?>" id="quantity<?= $number ?>"
                                           value="<?= $ingredient['quantity'] ?>" class="form-control">
                                </div>
                                <div class="col-4"> <!--unit div-->
                                    <select name="unit<?= $number ?>" id="unit<?= $number ?>" class="form-select"> <!--unit select-->
                                        <?php
                                        $units = $unitManager->getAll();
                                        foreach ($units as $unit) {
                                            /* @var Unit $unit */
                                            ?>
                                            <option <?php if ($ingredient['unit_id'] === $unit->getId()) {
                                                echo "selected";
                                            } ?> value="<?= $unit->getId() ?>"><?= $unit->getName() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            $number++;
                        }
                        ?>
                    </div>
                    <div>
                        <button id="addIngredientButton" type="button" class="btn btn-outline-primary">Ajouter un ingrédient</button>
                    </div>

                    <div class="my-2">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea name="content" id="content" cols="30"
                                  rows="10" class="form-control"><?= $recipe->getContent() ?></textarea>
                    </div>

                    <div class="my-2">
                        <label for="preparation_time_minutes" class="form-label">Temps de préparation (en
                            minutes)</label>
                        <input type="number" max="65535" name="preparation_time_minutes" id="preparation_time_minutes"
                               value="<?= $recipe->getPreparationTimeMinutes() ?>" class="form-control">
                    </div>

                    <div class="my-2">
                        <label for="cooking_time_minutes" class="form-label">Temps de cuisson (en minutes)</label>
                        <input type="number" max="65535" name="cooking_time_minutes" id="cooking_time_minutes"
                               class="form-control"
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
