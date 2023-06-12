<form action="/index.php/menu?action=validateNew" method="post">
    <label for="name">Nom du menu</label>
    <input name="name" id="name" type="text" maxlength="50">

    <div id="menuContainer">

    </div>

    <button type="button" id="addRecipeButton">Ajouter une recette</button>

    <input type="submit" value="Créer un menu">
</form>

<script defer src="/assets/addRecipe.js"></script>