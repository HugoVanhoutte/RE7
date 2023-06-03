<?php

use App\Controller\RootController;

if (!isset($_SESSION['user_id'])) {
    (new RootController())->displayError(403);
} else {
?>
<div class="container">
    <form action="/../RE7/public/index.php/recipe?action=validateWrite" method="post">

        <div>
            <label for="title">Titre de la recette</label>
            <input type="text" maxlength="50" required name="title" id="title">
        </div>

        <div>
            <label for="content">Contenu</label>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
        </div>

        <div>
            <label for="preparation_time_minutes">Temps de préparation (en minutes)</label>
            <input type="number" max="65535" name="preparation_time_minutes" id="preparation_time_minutes">
        </div>

        <div>
            <label for="cooking_time_minutes">Temps de cuisson (en minutes)</label>
            <input type="number" max="65535" name="cooking_time_minutes" id="cooking_time_minutes">
        </div>

        <div>
            <input type="submit" value="Créer ma recette">
        </div>
    </form>

    <?php
    }
    ?>

</div>
