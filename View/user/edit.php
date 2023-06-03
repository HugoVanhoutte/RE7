<?php

use App\Controller\RootController;
use App\Model\Manager\UserManager;

$userManager = new UserManager();

if (isset($_SESSION['user_id']) && $userManager->isEditable($params['id'])) {
    $user = $userManager->get($params['id'])
    ?>
    <div class="container">
        <form action="/../RE7/public/index.php/user?action=validateEdit&id=<?= $user->getId() ?>" method="post">
            <div>
                <label for="email">Modifier mon adresse mail: </label>
                <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" required>
            </div>
            <div>
                <label for="username">Modifier mon nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?= $user->getUsername() ?>" required>
            </div>
            <input type="submit" value="Editer">
        </form>
    </div>
    <?php
} else {
    (new RootController())->displayError(403);
}