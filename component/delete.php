<?php
    ob_start();
    session_start();
    $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);
        $request = $bdd->query(
            'SELECT user_id, img
            FROM film 
            WHERE id = ' . $id . '
        ');
        $data = $request->fetch();
        if ($_SESSION['currentUser'][0] == $data['user_id']) {
            $requestDelete = $bdd->prepare(
                'DELETE FROM film 
                WHERE id = '. $id . '
            ');
            $requestDelete->execute();
            unlink('./../assets/img/upload/'.$data['img']);
            header('location:http://localhost:8080/mediatheque/index.php');
        } else {
            header('location:http://localhost:8080/mediatheque/index.php');
        }
    }