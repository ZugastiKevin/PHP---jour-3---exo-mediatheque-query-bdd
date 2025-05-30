<?php
    include('../layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    $requestQueryFilm = $bdd->query(
        'SELECT id, titre, realisateur, genre, duree 
        FROM film 
        ORDER BY id DESC
    ');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les Film</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <h2>Tous les film, query</h2>
        <?php
            while($data = $requestQueryFilm->fetch()){
                echo '<h2>'.$data['titre'].'</h2>';
                echo '<ul>';
                    echo '<li>Le realisteur est: ' . $data['realisateur'] . '.</li>';
                    echo '<li>de genre: ' . $data['genre'] . '.</li>';
                    echo '<li>la duree est de: ' . $data['duree'] . ' minutes</li>';
                echo '</ul>';
                echo '<a href="http://localhost:8080/mediatheque/page/read.php?id=' . $data['id'] . '">voir plus</a>';
            }
        ?>
    </main>
</body>
</html>