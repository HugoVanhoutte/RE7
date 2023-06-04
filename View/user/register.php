<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-4 shadow rounded bg-light text-center">
            <form action="/../RE7/public/index.php/user?action=validateRegistration" method="post">
                <div class="my-2">
                    <label for="email" class="form-label">Adresse E-mail:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" id="email" required placeholder="ex: jean@mail.com" class="form-control">
                    </div>
                    </div>

                <div class="my-2">
                    <label for="username" class="form-label">Nom d'utilisateur:</label>
                    <div class="input-group"><span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" id="username" required maxlength="50"
                               placeholder="ex: jean456" class="form-control">
                    </div>
                </div>

                <div class="my-2">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="password" id="password"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}"
                               title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial."
                               required class="form-control">
                    </div>
                </div>

                <div class="my-2">
                    <label for="passwordConfirm" class="form-label">Confirmer mot de passe:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="passwordConfirm" id="passwordConfirm" required class="form-control">
                    </div>
                </div>

                <div class="my-3">
                    <input type="submit" value="Créer mon compte" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>