<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--<link rel="stylesheet" href="../../public/assets/style.css">-->
    <!-- TODO LINK TO CSS -->
    <title><?= $pageTitle ?></title>
</head>
<body>
<nav>
    <!--Navigation menu-->
    <!-- TODO Check links -->
    <ul>
        <li>
            <a href="/../RE7/public/index.php">Accueil</a>
            <?php
            if (!empty($_SESSION['user_id'])) {
                ?>
                <a href="/../RE7/public/index.php/user?action=logout">Déconnexion</a>
                <a href="/../RE7/public/index.php/user?action=profile&id=<?= $_SESSION['user_id'] ?>">Mon profil</a>
                <?php
            } else {
                ?>
                <a href="/../RE7/public/index.php/user?action=register">Créer un compte</a>
                <a href="/../RE7/public/index.php/user?action=login">Connexion</a>
                <?php
            }
            ?>
        </li>
    </ul>
</nav>

<?php
if (isset($params['message'])) {
    echo $params['message'];
}
?>

<?= $pageContent ?>

</body>
</html>