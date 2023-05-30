<?php
$user = $params['user'];
    /* @var User $user */

use App\Model\Manager\RoleManager;
use App\Model\Entity\User;
use App\Model\Manager\UserManager;
if ((new UserManager())->isEditable($user->getId()))
{
    ?>
        <div class="account_management">
            <a href="../index.php/user?action=edit&id=<?= $user->getId() ?>" title="&Eacute;diter mon profil"><i class="fa-solid fa-pen"></i></a>
            <a href="../index.php/user?action=delete&id=<?= $user->getId() ?>" title="Supprimer mon compte"><i class="fa-solid fa-trash"></i></a>
        </div>
            <?php
}
?>
<h1>Profil de <?= $user->getUsername() ?></h1>
<p><strong>Adresse Mail:</strong> <?= $user->getEmail() ?></p>
<p><strong>Rôle: </strong><?= (new RoleManager())->getRole($user->getRoleId()) ?></p>
<p><strong>Compte créé le </strong><?= (new UserManager())->getTimeFR($user->getRegistrationDateTime()) ?></p>

<h2>Liste des recettes de <?= $user->getUsername() ?></h2>

<h2>Liste des commentaires de <?= $user->getUsername() ?></h2>