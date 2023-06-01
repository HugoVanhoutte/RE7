<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/9010a17673.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../public/assets/style.css">
    <link rel="stylesheet" href="../public/assets/style.css">
    <!-- 2 links: second for homepage -->
    <title><?= $pageTitle ?></title>
</head>
<body>
<div class="navigation-menu">
    <nav>    <!--Navigation menu-->

                <a href="/../RE7/public/index.php" title="Accueil">Accueil</a>
                <?php
                if (!empty($_SESSION['user_id'])) {
                    ?>
                    <a href="/../RE7/public/index.php/recipe?action=write" title="Créer une nouvelle recette">Nouvelle
                        Recette</a>
                    <a href="/../RE7/public/index.php/user?action=logout" title="Déconnexion">Déconnexion</a>
                    <a href="/../RE7/public/index.php/user?action=profile&id=<?= $_SESSION['user_id'] ?>"
                       title="Mon profil">Mon profil</a>
                    <?php
                } else {
                    ?>
                    <a href="/../RE7/public/index.php/user?action=register" title="Créer un compte">Créer un compte</a>
                    <a href="/../RE7/public/index.php/user?action=login" title="Connexion">Connexion</a>
                    <?php
                }
                ?>
    </nav>
</div>
<?php
if (isset($params['error'])) {
    echo "<div class='error'><p>" . $params['error'] . "</p></div>";
}
if (isset($params['message'])) {
    echo "<div class='message'><p>" . $params['message'] . "</p></div>";
}
?>

<?= $pageContent ?>

</body>
</html>