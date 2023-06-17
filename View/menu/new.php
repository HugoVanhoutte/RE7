<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-6">
            <form action="/index.php/menu?action=validateNew" method="post">
                <label for="name">Nom du menu</label>
                <input name="name" id="name" type="text" maxlength="50" required class="form-control my-2">

                <div id="menuContainer">

                </div>

                <button type="button" id="addRecipeButton" class="btn btn-outline-primary"><span><i class="fa-solid fa-plus"></i></span> Ajouter une recette</button>

                <input type="submit" value="Créer un menu" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<script defer src="/assets/addRecipe.js"></script>