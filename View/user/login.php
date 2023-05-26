<form action="/../RE7/public/index.php/user?action=validateLogin" method="post">
    <div>
        <label for="email"><i class="fa-solid fa-envelope"></i></label>
        <input type="email" name="email" id="email" required placeholder="Adresse e-mail" class="text-input">
    </div>

    <div>
        <label for="password"><i class="fa-solid fa-key"></i></label>
        <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}"
               title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial."
               required placeholder="Mot de passe" class="text-input">
    </div>

    <div>
        <input type="submit" value="Connexion">
    </div>
    <a href="/../RE7/public/index.php/user?action=passwordReset">Mot de passe oublié</a>
</form>