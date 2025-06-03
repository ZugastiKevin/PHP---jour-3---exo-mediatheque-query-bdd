<?php
    include('./layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    $requestPrepareFilm = $bdd->prepare(
        'SELECT id, titre, realisateur, genre, duree 
        FROM film
        ORDER BY id DESC
        LIMIT 3
    ');
    $requestPrepareFilm->execute(array());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediatheque</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <main>
        <section id="last-3-movies">
            <div class="container last-3-movies">
                <div class="cards-container">
                    <h2>Les 3 dernier film:</h2>
                    <?php
                        while($data = $requestPrepareFilm->fetch()){
                            echo '<div class="card-content"><p>le titre du film est: ' . $data['titre'] . ' et le realisteur est: ' . $data['realisateur'] . ' et le genre est: ' . $data['genre'] . ' et la duree est de: ' . $data['duree'] . ' minutes</p><a href="./page/read.php?id=' . $data['id'] . '">voir plus</a></div>';
                        }
                    ?>
                </div>
            </div>
        </section>
        <section id="all-movies">
            <div class="container all-movies">
                <div class="cards-container">
                    <h2>Film:</h2>
                    <div class="card-content">
                        <a href="./page/readAll.php">Voir tous les film</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>