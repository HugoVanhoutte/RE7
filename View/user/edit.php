<?php

use App\Controller\RootController;
use App\Model\Manager\UserManager;

$userManager = new UserManager();

if ($userManager->isEditable($params['id'])) {
    $user = $userManager->get($params['id'])
    ?>
    <form action="/../RE7/public/index.php/user?action=validateEdit&id=<?= $user->getId() ?>" method="post">
        <div>
            <label for="email">Modifier mon adresse mail: </label>
            <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" required>
        </div>
        <div>
            <label for="username">modifier mon nom d'utilisateur</label>
            <input type="text" id="username" name="username" value="<?= $user->getUsername() ?>" required>
        </div>
        <input type="submit" value="Editer">
    </form>
    <?php
} else {
    (new RootController())->displayError(403);
}