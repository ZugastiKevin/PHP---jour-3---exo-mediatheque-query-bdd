<?php
    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    $requestDelete = $bdd->prepare(
        'DELETE FROM film 
        WHERE id = '. htmlspecialchars($_GET["id"]) . '
    ');
    $requestDelete->execute();
    header('location:http://localhost:8080/mediatheque/index.php');