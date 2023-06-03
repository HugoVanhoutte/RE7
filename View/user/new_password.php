<?php

use App\Controller\RootController;
use App\Model\Manager\UserManager;

$userManager = new UserManager();
$user = $userManager->get($params['id']);

/*if ($params['token'] !== $user->getToken()) { //Token are different, sends user to 403
    echo "test";
    (new RootController())->display('user/login', 'Login');
} else { //Token matches: display form*/
    ?>
<div class="container">
    <form action="../../public/index.php/user?action=validatePasswordReset&id=<?= $params['id'] ?>&token=<?= $params['token'] ?>" method="post">
        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        
        <div class="form-group">
            <label for="passwordConfirm">Confirmez nouveau mot de passe</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm">
        </div>

        <input type="submit" value="Confirmer">
    </form>
</div>
<?php
//}