<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= __DIR__ . '/../public/assets/style.css' ?>">
    <title><?= $pageTitle ?></title>
</head>
<body>


<nav>
    <!--Navigation menu-->
    <!-- TODO Check links -->
    <ul>
        <li>
            <a href="/../RE7/public/index.php">Accueil</a>
            <a href="/../RE7/public/index.php/user?action=register">Créer un compte</a>
            <a href="/../RE7/public/index.php/user?action=login">Se connecter</a>
        </li>
    </ul>
</nav>


<?= $pageContent ?>

</body>
</html>