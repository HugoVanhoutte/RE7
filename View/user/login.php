<form action="/../RE7/public/index.php/user?action=validateLogin" method="post">
    <div>
        <label for="email">Adresse mail</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}"
               title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial."
               required>
    </div>

    <div>
        <input type="submit" value="Connexion">
    </div>
    <a href="/../RE7/public/index.php/user?action=passwordReset">Mot de passe oublié</a>
    <!--TODO Password Reset-->
</form>