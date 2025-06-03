<?php
    include('../layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);
        $request = $bdd->prepare(
            "SELECT user_id,titre,realisateur,genre,duree,synopsis,img
            FROM film 
            WHERE id = :id
        ");
        $request->execute(['id'=>$id]);
        $data = $request->fetch();
        if ($_SESSION['currentUser'][0] == $data['user_id']) {
            if (isset($_POST['title']) && isset($_POST['realisator']) && isset($_POST['gender']) && isset($_POST['time']) && isset($_POST['synopsis']) && isset($_FILES["filmFile"])) {
                $title = htmlspecialchars($_POST['title']);
                $realisator = htmlspecialchars($_POST['realisator']);
                $gender = htmlspecialchars($_POST['gender']);
                $time = htmlspecialchars($_POST['time']);
                $synopsis = htmlspecialchars($_POST['synopsis']);
                $img = $_FILES['filmFile'];
                $getExtension = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
                $extensionType = ['png','jpeg','jpg','webp','bmp','svg'];

                $finalTitle = $title ? $title : $data['titre'];
                $finalRealisator = $realisator ? $realisator : $data['realisateur'];
                $finalGender = $gender ? $gender : $data['genre'];
                $finalTime = $time ? $time : $data['duree'];
                $finalSynopsis = $synopsis ? $synopsis : $data['synopsis'];

                switch ($_FILES["filmFile"]['error']) {
                    case 4:
                        $requestUpdate = $bdd->prepare(
                            "UPDATE film 
                            SET titre = :titre, realisateur = :realisateur, genre = :genre, duree = :duree, synopsis = :synopsis
                            WHERE id = :id
                        ");
                        $requestUpdate->execute(['id'=>$id, 'titre'=>$finalTitle, 'realisateur'=>$finalRealisator,  'genre'=>$finalGender, 'duree'=>$finalTime, 'synopsis'=>$finalSynopsis]);
                        header('location:http://localhost:8080/mediatheque/page/read.php?id='.$id);
                        break;
                    case  0:
                        if(!in_array($getExtension, $extensionType)){
                            echo "Extension non autorisée : ".$getExtension." format valide: png, jpeg, jpg, webp, bmp, svg</p>";
                        } else {
                            $uniqueName = uniqid().'.'.$getExtension;
                            move_uploaded_file($_FILES['filmFile']['tmp_name'],"./../assets/img/upload/".$uniqueName);
                            var_dump($data['img']);
                            if ($data['img'] != '0.jpg') {
                                unlink('./../assets/img/upload/'.$data['img']);
                            }
                            $requestUpdate = $bdd->prepare(
                                "UPDATE film 
                                SET titre = ?, realisateur = ?, genre = ?, duree = ?, synopsis = ?, img = ?
                                WHERE id = ('$id')
                            ");
                            $requestUpdate->execute([$finalTitle, $finalRealisator,  $finalGender, $finalTime, $finalSynopsis, $uniqueName]);
                            header('location:http://localhost:8080/mediatheque/page/read.php?id='.$id);
                        }
                        break;
                }
            }
        } else {
            header('location:http://localhost:8080/mediatheque/page/read.php?id='.$id);
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
        <!--<form action="update_film.php" method="post" enctype="multipart/form-data">-->
        <?php echo '<form action="update_film.php?id='.$id.'" method="post" enctype="multipart/form-data">'; ?>
            <input type="text" name="title" placeholder="titre du film">
            <input type="text" name="realisator" placeholder="nom du realisateur">
            <input type="text" name="gender" placeholder="genre du film">
            <input type="number" name="time" placeholder="duree du film">
            <input type="text" name="synopsis" placeholder="le synopsis">
            <label for="filmFile">Upload l'image du film</label>
            <input type="file" name="filmFile">
            <input type="submit" value="Envoyer">
        </form>
    </main>
</body>
</html>