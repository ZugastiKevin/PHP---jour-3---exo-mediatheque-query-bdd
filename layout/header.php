<?php
    include('/var/www/html/mediatheque/component/session.php');
?>

<header>
    <nav id="container">
        <a href="http://localhost:8080/mediatheque/index.php">Accueil</a>
        <?php
            if (isset($_SESSION["currentUser"])) {
                echo '<h1>Bonjour, ' . $_SESSION["currentUser"]['nom'] . '</h1>';
            } else {
                echo '<h1></h1>';
            }
        ?>
        <ul class="nav-list">
            <?php
                if (isset($_SESSION["currentUser"])) {
                    echo '<li><a href="/mediatheque/page/create_film.php">ajouter une fiche de film</a></li>';
                    echo '<li><a href="/mediatheque/component/logout.php">Se deconnecter</a></li>';
                } else {
                    echo '<li><a href="/mediatheque/page/create_user.php">Cree un compte</a></li>';
                    echo '<li><a href="/mediatheque/page/login.php">Se connecter</a></li>';
                }
            ?>
        </ul>
    </nav>
</header>