<div class="container">
    <div class="row justify-content-center">
        <form action="/../RE7/public/index.php/user?action=validateRegistration" method="post" class="col-lg-3 col-md-5 col-6 rounded shadow py-3 text-center">
            <div class="form-group p-1">
                <label for="email"><i class="fa-solid fa-envelope"></i></label>
                <input type="email" name="email" id="email" required placeholder="Adresse e-mail">
            </div>

            <div class="form-group p-1">
                <label for="username"><i class="fa-solid fa-user"></i></label>
                <input type="text" name="username" id="username" required maxlength="50" placeholder="Nom d'utilisateur">
            </div>

            <div class="form-group p-1">
                <label for="password"><i class="fa-solid fa-key"></i></label>
                <input type="password" name="password" id="password"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}"
                       title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial."
                       required placeholder="Mot de passe">
            </div>

            <div class="form-group p-1">
                <label for="passwordConfirm"><i class="fa-solid fa-key"></i></label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" required
                       placeholder="Confirmer mot de passe">
            </div>

            <div class="form-group p-3">
                <input type="submit" value="Créer mon compte" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>