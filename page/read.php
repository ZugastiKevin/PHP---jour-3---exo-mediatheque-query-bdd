<?php
    include('../layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    $requestPrepare = $bdd->prepare(
        'SELECT id, user_id, titre, realisateur, genre, duree, synopsis, img
        FROM film
        WHERE id = :id
    ');
    $requestPrepare->execute(['id' => htmlspecialchars($_GET["id"])]));
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
            <div class="container film">
                <div class="cards-container">
                    <h2>Film par id</h2>
                    <?php
                        while($data = $requestPrepare->fetch()){
                            echo '<div class="container-img">';
                                echo '<img src="./../assets/img/upload/'.$data['img'].'" alt="une image du film">';
                            echo '</div>';
                            echo '<div class="card-content-film">';
                                echo '<h2>'.$data['titre'].'</h2>';
                                echo '<ul>';
                                    echo '<li>Le realisteur est: ' . $data['realisateur'] . '.</li>';
                                    echo '<li>de genre: ' . $data['genre'] . '.</li>';
                                    echo '<li>la duree est de: ' . $data['duree'] . ' minutes</li>';
                                echo '</ul>';
                                echo '<h3>Le synopsis:</h3>';
                                echo '<p>' . $data['synopsis'] . '</p>';
                            echo '</div>';
                            if ($_SESSION['currentUser'][0] == $data['user_id']) {
                                echo '<div class="container-option">';
                                    echo '<a href="http://localhost:8080/mediatheque/page/update_film.php?id=' . $data['id'] . '">Modifier</a>';
                                    echo '<a href="http://localhost:8080/mediatheque/component/delete.php?id=' . $data['id'] . '">Suprimer</a>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>