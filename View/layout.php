<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/9010a17673.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>RE7: <?= $pageTitle ?></title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary mb-4">    <!--Navbar-->
    <div class="container">
        <a href="/index.php" title="Accueil" class="navbar-brand"><span class="text-light">RE7</span></a> <!-- IDE error is wrong: link works on deployment -->
        <!-- Toggle button for mobile navigation -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav"><span
                    class="navbar-toggler-icon"></span></button>

        <!--Navbar links-->
        <div class="collapse navbar-collapse justify-content-end align-center" id="main-nav">
            <ul class="navbar-nav">
                <?php
                if (!empty($_SESSION['user_id'])) {
                    ?>
                        <li class="nav-item">
                            <a href="/index.php/ingredient?action=new" title="Ajouter un ingrédient" class="nav-link">Nouvel Ingrédient</a>
                        </li>

                    <li class="nav-item">
                        <a href="/index.php/unit?action=new" title="Ajouter une unité" class="nav-link">Nouvelle Unité</a>
                    </li>

                    <li class="nav-item">
                        <a href="/index.php/recipe?action=write" title="Créer une nouvelle recette" class="nav-link">Nouvelle
                            Recette</a>
                    </li>


                    <li class="nav-item">
                        <a href="/index.php/user?action=profile&id=<?= $_SESSION['user_id'] ?>"
                           title="Mon profil" class="nav-link">Mon profil</a>
                    </li>

                    <li class="nav-item">
                        <a href="/index.php/user?action=logout" title="Déconnexion" class="nav-link">Déconnexion</a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a href="/index.php/user?action=register" title="Créer un compte" class="nav-link">Créer un
                            compte</a>
                    </li>

                    <li class="nav-item">
                        <a href="/index.php/user?action=login" title="Connexion" class="nav-link">Connexion</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<?php

//Error/Info messages display
if (isset($params['error'])) {
    echo "<div class='container-sm rounded bg-danger text-center'>
<p class='text-light'>" . $params['error'] . "</p></div>";
}
if (isset($params['message'])) {
    echo "<div class='container-sm rounded bg-success text-center text-light'><p>" . $params['message'] . "</p></div>";
}
?>

<?= $pageContent ?>

<footer class="bg-dark text-light mt-5 container-fluid"> <!-- TODO -->
    <div class="row">
        <div class="col text-start">
            <ul class="list-unstyled">
                <li><h3>Contact</h3></li>
                <li><a href="mailto: hugo.vanhoutte.pro@gmail.com" title="Mail" class="text-muted display-6"><i class="fa-solid fa-envelope"></i></a></li>
                <li><a href="#" title="Twitter" class="text-muted display-6"><i class="fa-brands fa-square-twitter"></i></a></li>
                <li><a href="#" title="Facebook" class="text-muted display-6"><i class="fa-brands fa-square-facebook"></i></a></li>
            </ul>
        </div>

        <div class="col">
            <ul class="list-unstyled text-end">
                    <li><h3>Mentions légales</h3></li>
                    <li><a href="/index.php/user?action=rgpd" class="text-muted">RGPD</a></li>
            </ul>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>