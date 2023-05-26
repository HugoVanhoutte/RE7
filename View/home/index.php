<?php

use App\Model\Entity\User;
use App\Model\Manager\UserManager;

if (isset($_SESSION['user_id'])) {
        $user = (new UserManager())->get($_SESSION['user_id']);
    } else $user = (new User())->setUsername("invité")
?>


<h1>Bienvenue <strong><?= $user->getUsername() ?></strong></h1>

<div>
    <p>Le site RE7 vous propose de créer et partager des recettes avec d'autres personnes, en créant des groupes et des menus, mais aussi en partageant celles-ci de manière publique !</p>
</div>

<h2>Les recettes les plus likées: </h2>
<!-- TODO -->