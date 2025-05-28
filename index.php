<?php 
    ob_start();
    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    $request = $bdd->query('SELECT titre, realisateur, genre, duree 
                            FROM film 
                            ORDER BY id DESC
                            LIMIT 3');
    $requestPrepare = $bdd->prepare('SELECT titre, realisateur, genre, duree 
                                    FROM film
                                    ORDER BY id DESC
                                    LIMIT 3');
    $requestPrepare->execute(array());

    /*if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        $firstName = htmlspecialchars($_POST['firstname']);
        $lastName = htmlspecialchars($_POST['lastname']);
        $requestCreate = $bdd->prepare('INSERT INTO user(prenom,nom) VALUES(?,?)');
        $requestCreate->execute(array($firstName,$lastName));
        header("location:index.php");
    }*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediatheque</title>
    <style>
        a {
            padding: 1rem 2rem;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: black;
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <h2>query</h2>
    <?php
        while($data = $request->fetch()){
            echo '<p>le titre du film est: ' . $data['titre'] . ' et le realisteur est: ' . $data['realisateur'] . ' et le genre est: ' . $data['genre'] . ' et la duree est de: ' . $data['duree'] . ' minutes</p>';
        }
    ?>
    <h2>prepare</h2>
    <?php
        while($data = $requestPrepare->fetch()){
            echo '<p>le titre du film est: ' . $data['titre'] . ' et le realisteur est: ' . $data['realisateur'] . ' et le genre est: ' . $data['genre'] . ' et la duree est de: ' . $data['duree'] . ' minutes</p>';
        }
    ?>
    <!--<h2>Formulaire</h2>
    <form action="index.php" method="post">
        <input type="text" name="firstname" placeholder="votre prenom">
        <input type="text" name="lastname" placeholder="votre nom">
        <input type="submit" value="Envoyer">
    </form>-->
    <h2>Film</h2>
    <a href="form.php">ajouter une fiche de film</a>
</body>
</html>