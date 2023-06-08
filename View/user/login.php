<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-4 shadow rounded bg-light text-center">
            <form action="/index.php/user?action=validateLogin" method="post">
                <div class="my-2">
                    <label for="email" class="form-label">Adresse E-Mail:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" id="email" required class="form-control">
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

                <div class="my-3">
                    <input type="submit" value="Connexion" title="Connexion" class="btn btn-primary mb-1">
                    <a href="/index.php/user?action=passwordReset" title="Mot de passe oublié"
                       class="btn btn-outline-primary btn-sm">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
</div>