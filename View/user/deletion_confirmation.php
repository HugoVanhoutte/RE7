<?php

use App\Controller\RootController;
use App\Model\Manager\UserManager;

if (!(new UserManager())->isEditable($params['id'])) {
    (new RootController())->displayError(403);
}
?>

<form action="../../public/index.php/user?action=deletion_validated&id=<?= $params['id'] ?>" method="post">
    <h2>Que souhaitez vous supprimer ?</h2>
    <input type="radio" name="deleteAll" value="true"><p>Tout: mon profil ainsi que tout le contenu que j'ai ajouté sur le site.</p>
    <input type="radio" name="deleteAll" value="false" checked="checked"><p>Seulement mon profil : Le contenu que j'ai ajouté au site sera alors entièrement anonymisé, mais sera toujours visible.</p>
    <input type="submit" value="Confirmer mon choix">
    <p>Attention! Si vous supprimez votre compte, il ne vous sera pas possible de revenir en arrière, si vous ne supprimez pas votre contenu, il ne sera plus possible de le supprimer ultérieurement</p>
</form>
