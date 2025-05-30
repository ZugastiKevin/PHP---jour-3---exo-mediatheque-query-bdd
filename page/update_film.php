<?php
    include('../layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');

    if (isset($_POST['title']) && isset($_POST['realisator']) && isset($_POST['gender']) && isset($_POST['time']) && isset($_POST['synopsis']) && isset($_FILES["filmFile"])) {
        $title = htmlspecialchars($_POST['title']);
        $realisator = htmlspecialchars($_POST['realisator']);
        $gender = htmlspecialchars($_POST['gender']);
        $time = htmlspecialchars($_POST['time']);
        $synopsis = htmlspecialchars($_POST['synopsis']);
        $img = $_FILES['filmFile'];
        $getExtension = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
        $extensionType = ['png','jpeg','jpg','webp','bmp','svg'];
        var_dump($_SESSION["currentUser"][0]);

        switch ($_FILES["filmFile"]['error']) {
            case 4:
                $requestCreate = $bdd->prepare(
                    'INSERT INTO film(titre,realisateur,genre,duree,synopsis,img,user_id) 
                    VALUES (:titre,:realisateur,:genre,:duree,:synopsis,:img,:user_id)
                ');
                $requestCreate->execute([
                    'titre'=>$title,
                    'realisateur'=>$realisator,
                    'genre'=>$gender,
                    'duree'=>$time,
                    'synopsis'=>$synopsis,
                    'img'=>0,
                    'user_id'=>$_SESSION["currentUser"][0]
                ]);
                header('location:http://localhost:8080/mediatheque/index.php');
                break;
            case  0:
                if(!in_array($getExtension, $extensionType)){
                    echo "Extension non autorisée : ".$getExtension." format valide: png, jpeg, jpg, webp, bmp, svg</p>";
                } else {
                    $uniqueName = uniqid().'.'.$getExtension;
                    move_uploaded_file($_FILES['filmFile']['tmp_name'],"./../assets/img/upload/".$uniqueName);
                    $requestCreate = $bdd->prepare(
                        'INSERT INTO film(titre,realisateur,genre,duree,synopsis,img,user_id) 
                        VALUES (:titre,:realisateur,:genre,:duree,:synopsis,:img,:user_id)
                    ');
                    $requestCreate->execute([
                        'titre'=>$title,
                        'realisateur'=>$realisator,
                        'genre'=>$gender,
                        'duree'=>$time,
                        'synopsis'=>$synopsis,
                        'img'=>$uniqueName,
                        'user_id'=>$_SESSION["currentUser"]['0']
                    ]);
                    header('location:http://localhost:8080/mediatheque/index.php');
                }
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un film</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <h2>Formulaire</h2>
        <form action="create_film.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="titre du film" required>
            <input type="text" name="realisator" placeholder="nom du realisateur" required>
            <input type="text" name="gender" placeholder="genre du film" required>
            <input type="number" name="time" placeholder="duree du film" required>
            <input type="text" name="synopsis" placeholder="le synopsis">
            <label for="filmFile">Upload l'image du film</label>
            <input type="file" name="filmFile">
            <input type="submit" value="Envoyer">
        </form>
    </main>
</body>
</html>