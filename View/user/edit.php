<?php

use App\Controller\RootController;
use App\Model\Manager\UserManager;

//Checks if user authorised
$userManager = new UserManager();

if (isset($_SESSION['user_id']) && $userManager->isAuthor($params['id'])) {
    $user = $userManager->get($params['id'])
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-4 shadow rounded bg-light text-center">
                <form action="/index.php/user?action=validateEdit&id=<?= $user->getId() ?>" method="post">
                    <div class="my-2">
                        <label for="email" class="form-label">Modifier mon adresse mail: </label>
                        <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" required class="form-control">
                    </div>

                    <div class="my-2">
                        <label for="username" class="form-label">Modifier mon nom d'utilisateur</label>
                        <input type="text" id="username" name="username" value="<?= $user->getUsername() ?>" required class="form-control">
                    </div>
                    <div class="my-3">
                        <input type="submit" value="Editer" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
} else {
    (new RootController())->displayError(403);
}