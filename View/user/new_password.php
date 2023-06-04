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
        <div class="row justify-content-center">
            <div class="col col-md-4 shadow rounded bg-light text-center">
                <form action="../../public/index.php/user?action=validatePasswordReset&id=<?= $params['id'] ?>&token=<?= $params['token'] ?>"
                      method="post">
                    <div class="my-2">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="my-2">
                        <label for="passwordConfirm" class="form-label">Confirmez nouveau mot de passe</label>
                        <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control">
                    </div>
                    <div class="my-3">
                        <input type="submit" value="Confirmer" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
//}