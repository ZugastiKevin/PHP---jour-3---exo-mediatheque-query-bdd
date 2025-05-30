<?php
    include('../layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    $request = $bdd->query(
        'SELECT id, titre, realisateur, genre, duree, synopsis, img
        FROM film 
        WHERE id = ' . htmlspecialchars($_GET["id"]) . '
    ');
    $requestPrepare = $bdd->prepare(
        'SELECT id, titre, realisateur, genre, duree, synopsis, img
        FROM film
        WHERE id = '. htmlspecialchars($_GET["id"]) . '
    ');
    $requestPrepare->execute(array());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le film</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <section>
            <h2>Film par id, query</h2>
            <div class="container film">
                <?php
                    while($data = $request->fetch()){
                        echo '<div class="container-img">';
                            echo '<img src="./../assets/img/upload/'.$data['img'].'" alt="une image du film">';
                        echo '</div>';
                        echo '<div class="container-body">';
                            echo '<h2>'.$data['titre'].'</h2>';
                            echo '<ul>';
                                echo '<li>Le realisteur est: ' . $data['realisateur'] . '.</li>';
                                echo '<li>de genre: ' . $data['genre'] . '.</li>';
                                echo '<li>la duree est de: ' . $data['duree'] . ' minutes</li>';
                            echo '</ul>';
                            echo '<h3>Le synopsis:</h3>';
                            echo '<p>' . $data['synopsis'] . '</p>';
                        echo '</div>';
                        echo '<div class="container-option">';
                            echo '<a href="http://localhost:8080/mediatheque/page/updateFilm.php?id=' . $data['id'] . '">Modifier</a>';
                            echo '<a href="http://localhost:8080/mediatheque/component/delete.php?id=' . $data['id'] . '">Suprimer</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </section>
        <section>
            <h2>Film par id, prepare</h2>
            <div class="container film">
                <?php
                    while($data = $requestPrepare->fetch()){
                        echo '<div class="container-img">';
                            echo '<img src="./../assets/img/upload/'.$data['img'].'" alt="une image du film">';
                        echo '</div>';
                        echo '<div class="container-body">';
                            echo '<h2>'.$data['titre'].'</h2>';
                            echo '<ul>';
                                echo '<li>Le realisteur est: ' . $data['realisateur'] . '.</li>';
                                echo '<li>de genre: ' . $data['genre'] . '.</li>';
                                echo '<li>la duree est de: ' . $data['duree'] . ' minutes</li>';
                            echo '</ul>';
                            echo '<h3>Le synopsis:</h3>';
                            echo '<p>' . $data['synopsis'] . '</p>';
                        echo '</div>';
                        echo '<div class="container-option">';
                            echo '<a href="http://localhost:8080/mediatheque/page/update_film.php?id=' . $data['id'] . '">Modifier</a>';
                            echo '<a href="http://localhost:8080/mediatheque/component/delete.php?id=' . $data['id'] . '">Suprimer</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </section>
    </main>
</body>
</html>