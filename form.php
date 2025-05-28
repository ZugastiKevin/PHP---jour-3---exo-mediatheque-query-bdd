<?php 
    ob_start();
    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');

    if (!empty($_POST['title']) && !empty($_POST['realisator']) && !empty($_POST['gender']) && !empty($_POST['time']) && !empty($_POST['synopsis'])) {
        $title = htmlspecialchars($_POST['title']);
        $realisator = htmlspecialchars($_POST['realisator']);
        $gender = htmlspecialchars($_POST['gender']);
        $time = htmlspecialchars($_POST['time']);
        $synopsis = htmlspecialchars($_POST['synopsis']);
        $requestCreate = $bdd->prepare('INSERT INTO film(titre,realisateur,genre,duree,synopsis) 
                                        VALUES (:titre,:realisateur,:genre,:duree,:synopsis)');
        $requestCreate->execute([
            'titre'=>$title,
            'realisateur'=>$realisator,
            'genre'=>$gender,
            'duree'=>$time,
            'synopsis'=>$synopsis
        ]);
        header('location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un film</title>
</head>
<body>
    <h2>Formulaire</h2>
    <form action="form.php" method="post">
        <input type="text" name="title" placeholder="titre du film">
        <input type="text" name="realisator" placeholder="nom du realisateur">
        <input type="text" name="gender" placeholder="genre du film">
        <input type="number" name="time" placeholder="duree du film">
        <input type="text" name="synopsis" placeholder="le synopsis">
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>