<div class="container">
    <div class="justify-content-center">
        <div class="col col-md-4 shadow rounded bg-light text-center">
            <form action="/index.php/user?action=validateRegistration" method="post" class="needs-validation"
                  novalidate>
                <div class="my-2">
                    <label for="email" class="form-label">Adresse E-mail:</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" id="email" required placeholder="ex: jean@mail.com"
                               class="form-control">
                        <div class="invalid-feedback">
                            L'adresse E-mail n'est pas valide
                        </div>
                    </div>
                </div>

                <div class="my-2">
                    <label for="username" class="form-label">Nom d'utilisateur:</label>
                    <div class="input-group has-validation"><span class="input-group-text"><i
                                    class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" id="username" required maxlength="50"
                               placeholder="ex: jean456" class="form-control">
                        <div class="invalid-feedback">
                            Le nom d'utilisateur n'est pas valide
                        </div>
                    </div>
                </div>

                <div class="my-2">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="password" id="password"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}" required
                               class="form-control"
                               title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial(!@#$%^&*()_+).">
                        <span class="input-group-text"><i class="fa-solid fa-eye passwordVisibility"></i></span>
                        <div class="invalid-feedback">
                            le mot de passe n'est pas valide
                        </div>
                    </div>
                    <div class="row justify-content-evenly mt-2">
                        <div class="col-1 border rounded bg-danger text-light" id="password-validation-length"
                             title="Votre mot de passe doit contenir au minimum 8 caractères">8
                        </div>
                        <div class="col-1 border rounded bg-danger text-light" id="password-validation-lc"
                             title="Votre mot de passe doit contenir au minimum une lettre minuscule">a
                        </div>
                        <div class="col-1 border rounded bg-danger text-light" id="password-validation-uc"
                             title="Votre mot de passe doit contenir au minimum une lettre majuscule">A
                        </div>
                        <div class="col-1 border rounded bg-danger text-light" id="password-validation-number"
                             title="Votre mot de passe doit contenir au minimum un chiffre">1
                        </div>
                        <div class="col-1 border rounded bg-danger text-light" id="password-validation-spec"
                             title="Votre mot de passe doit contenir au minimum un caractère spécial (!@#$%^&*()_+)">#
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <label for="passwordConfirm" class="form-label">Confirmer mot de passe:</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="passwordConfirm" id="passwordConfirm" required
                               class="form-control">
                        <span class="input-group-text"><i class="fa-solid fa-eye passwordVisibility"></i></span>
                        <div class="invalid-feedback">
                            Veuillez confirmer votre mot de passe
                        </div>
                    </div>
                </div>

                <small class="text-muted fst-italic">En cliquant sur créer mon compte, je certifie avoir lu et approuver
                    les <a href="/index.php/user?action=rgpd">mentions légales.</a></small>
                <div class="my-3">
                    <input type="submit" value="Créer mon compte" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- IDE error wrong: links works -->
<script defer src="/assets/formsCheck.js"></script>
<script defer src="/assets/passwordVisibility.js"></script>