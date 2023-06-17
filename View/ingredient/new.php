<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-3">
            <form action="/index.php/ingredient?action=validateNew" method="post" class="needs-validation">
                <label for="name">Nom de l'ingrédient: </label>
                <input type="text" name="name" id="name" required class="form-control my-2">

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Ajouter un ingrédient</button>
            </form>
        </div>
    </div>
</div>