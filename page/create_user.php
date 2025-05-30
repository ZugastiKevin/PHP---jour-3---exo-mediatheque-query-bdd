<?php
    include('./layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');

    if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["password"])) {
        $firstName = trim(htmlspecialchars($_POST["firstname"]));
        $lastName = trim(htmlspecialchars($_POST["firstname"]));
        $encryption = password_hash(trim(htmlspecialchars($_POST["password"])), PASSWORD_ARGON2I);
        $requestCreate = $bdd->prepare('INSERT INTO user(nom,prenom,pass) 
                                        VALUES (:nom,:prenom,:pass)');
        $requestCreate->execute([
            'nom'=>$lastName,
            'prenom'=>$firstName,
            'pass'=>$encryption
        ]);
        $requestPrepareUser = $bdd->prepare(
            "SELECT id, nom, prenom
            FROM user
            WHERE (nom = '$lastName') AND prenom = ('$firstName')
        ");
        $data = $requestPrepareUser->execute(array());
        $_SESSION["currentUser"] = [$data['id'], $data['nom'], $data['prenom']];
        header('location:http://localhost:8080/mediatheque/index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation de compte</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <form action="create_user.php" method="post">
            <label for="firstname">Votre prenom:</label>
            <input type="text" name="firstname" required>
            <label for="lastname">Votre nom:</label>
            <input type="text" name="lastname" required>
            <label for="password">Mots de passe:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Cree mon compte">
        </form>
    </main>
</body>
</html>