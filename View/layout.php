<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $pageTitle ?></title>
</head>
<body>

<nav>
    <!--Navigation menu-->
    <ul>
        <li>
            <a href="<?= __DIR__ . '/../public/index.php' ?>">Accueil</a>
        </li>
    </ul>
</nav>

<?= $pageContent ?>

</body>
</html>