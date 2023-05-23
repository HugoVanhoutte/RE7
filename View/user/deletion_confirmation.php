<?php

use App\Controller\RootController;
use App\Model\Manager\UserManager;

if (!(new UserManager())->isEditable($params['id'])) {
    (new RootController())->displayError(403);
}
?>

<form action="deletion_validated"><!--TODO-->
    <h2>Que souhaitez vous supprimer ?</h2>
    <input type="radio" name="deletionChoice" value="all"><p>Tout: mon profil ainsi que tout le contenu que j'ai ajouté sur le site.</p>
    <input type="radio" name="deletionChoice" value="onlyProfile"><p>Seulement mon profil : Le contenu que j'ai ajouté au site sera alors entièrement anonymisé, mais sera toujours visible.</p>
    <input type="submit" value="Confirmer mon choix">
</form>
