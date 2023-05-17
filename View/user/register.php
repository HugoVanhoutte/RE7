<!--TODO ERROR MANAGEMENT-->
<?php
if (isset($params['error'])) {
    echo $params["error"];
} else {
    echo "Pas d'erreurs"
;}
?>
<form action="/../RE7/public/index.php/user?action=validateRegister" method="post">
    <div>
        <label for="email">Adresse mail</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div>
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required maxlength="50">
    </div>

    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{8,}"
               title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial."
               required>
    </div>

    <div>
        <label for="passwordConfirm">Confirmer le mot de passe</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" required>
    </div>

    <div>
        <input type="submit" value="Créer mon compte">
    </div>
</form>