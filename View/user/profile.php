<?php
$user = $params['user'];
    /* @var User $user */

use App\Model\Manager\RoleManager;
use App\Model\Entity\User;
use App\Model\Manager\UserManager;
if ((new UserManager())->isEditable($user->getId()))
{
    ?>
    <a href="../index.php/user?action=edit&id=<?= $user->getId() ?>">Editer</a>
    <a href="">Supprimer mon compte</a>
<?php
}
?>
<h1>Profil de <?= $user->getUsername() ?></h1>
<p><strong>Adresse Mail:</strong> <?= $user->getEmail() ?></p>
<p><strong>Rôle: </strong><?= (new RoleManager())->getRole($user->getRoleId()) ?></p>
<p><strong>Compte créé le </strong><?= (new UserManager())->getTimeFR($user->getRegistrationDateTime()) ?></p>