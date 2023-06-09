<?php

use App\Controller\RootController;
use App\Model\Entity\Ingredient;
use App\Model\Entity\Unit;
use App\Model\Manager\IngredientManager;
use App\Model\Manager\UnitManager;

if (!isset($_SESSION['user_id'])) {
    (new RootController())->displayError(403);
} else {
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 shadow rounded bg-light text-center">
                <form action="/index.php/recipe?action=validateWrite" method="post">
                    <div class="my-2">
                        <label for="title" class="form-label">Titre de la recette</label>
                        <input type="text" maxlength="50" required name="title" id="title" class="form-control">
                    </div>

                    <!--TODO: AddIngredient Button-->

                    <div class="my-2" id="ingredient">
                        <label>Ingredients</label>
                        <select name="ingredient" id="ingredient">
                            <?php
                            $ingredients = (new IngredientManager())->getAll();
                            foreach($ingredients as $ingredient)
                            /* @var Ingredient $ingredient*/
                            {
                                ?>
                                <option value="<?= $ingredient->getId() ?>"><?= $ingredient->getName() ?></option>
                                    <?php
                            }
                            ?>
                        </select>

                        <label for="quantity"></label>
                        <input name="quantity" id="quantity" type="number" min="1" max="10000">

                        <select name="unit" id="unit">
                            <?php
                            $units = (new UnitManager())->getAll();
                            foreach($units as $unit)
                                /* @var Unit $unit */
                            {
                                ?>
                                <option value="<?= $unit->getId() ?>"><?= $unit->getName() ?></option>
                                    <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="my-2">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="my-2">
                        <label for="preparation_time_minutes" class="form-label">Temps de préparation (en minutes)</label>
                        <input type="number" max="65535" name="preparation_time_minutes" id="preparation_time_minutes" class="form-control">
                    </div>

                    <div class="my-2">
                        <label for="cooking_time_minutes" class="form-label">Temps de cuisson (en minutes)</label>
                        <input type="number" max="65535" name="cooking_time_minutes" id="cooking_time_minutes" class="form-control">
                    </div>

                    <div class="my-3">
                        <input type="submit" value="Créer ma recette" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}