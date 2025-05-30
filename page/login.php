<?php
    include('../layout/header.php');

    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['password'])) {
        $firstName = trim(htmlspecialchars($_POST["firstname"]));
        $lastName = trim(htmlspecialchars($_POST["lastname"]));
        $requestPrepareUser = $bdd->prepare(
            "SELECT id, nom, prenom, pass
            FROM user
            WHERE nom = ('$lastName') AND prenom = ('$firstName')
        ");
        $requestPrepareUser->execute(array());
        $data = $requestPrepareUser->fetch();
        $encryption = trim(htmlspecialchars($_POST["password"]));
        if (password_verify($encryption, $data['pass'])) {
                $_SESSION["currentUser"] = [$data['id'], $data['nom'], $data['prenom']];
                header("location:http://localhost:8080/mediatheque/index.php");
        } else {
            header("location:http://localhost:8080/mediatheque/component/login.php?error=3");
        }
    }
    if (isset($_GET["error"])) {
        if ($_GET["error"] == 3) {
            echo "Pseudo or Password incorrect";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <form action="login.php" method="post">
            <label for="firstname">Votre prenom:</label>
            <input type="text" name="firstname" required>
            <label for="lastname">Votre nom:</label>
            <input type="text" name="lastname" required>
            <label for="password">Mots de passe:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Connection">
        </form>
    </main>
</body>
</html>