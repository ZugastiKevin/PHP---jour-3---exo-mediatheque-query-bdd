<?php 
    ob_start();
    session_start();

    //if (isset($_COOKIE['token-user'])) {
        //$bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
        //var_dump($_COOKIE['token-user']);
        //$token = $_COOKIE['token-user'];
        //$requestPrepareUser = $bdd->prepare(
            //"SELECT id, nom, prenom
            //FROM user
            //WHERE token = :token
        //");
        //$requestPrepareUser->execute(['token'=>sha1($token)]);
        //$data = $requestPrepareUser->fetch();
        //$_SESSION["currentUser"] = ['id'=>$data['id'], 'nom'=>$data['nom'], 'prenom'=>$data['prenom']];
        //updateToken($data['id']);
    //}

    function deleteToken($id) {
        $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
        var_dump($id);
        $requestUpdate = $bdd->prepare(
            "UPDATE user 
            SET token = :token, tokenValidate = :tokenValidate
            WHERE id = :id
        ");
        $requestUpdate->execute(['id'=>$id, 'token'=>null, 'tokenValidate'=>null]);
        var_dump("test2");
        setcookie('token-user', ' ', time() - 3600);
        session_unset();
        session_destroy();
        //header("location:http://localhost:8080/mediatheque/index.php");
    }

    function updateToken($id) {
        $bdd = new PDO('mysql:host=mysql;dbname=mediatheque;charset=utf8','root','root');
        $token = bin2hex(random_bytes(32));
        $time = time() + (7 * 24 * 60 * 60);
        $requestUpdate = $bdd->prepare(
            "UPDATE user 
            SET token = :token, tokenValidate = :tokenValidate
            WHERE id = :id
        ");
        $requestUpdate->execute(['id'=>$id, 'token'=>sha1($token), 'tokenValidate'=>$time]);

        setcookie('token-user', $token, $time);
    }

    function createSessionUserWithRemember($id, $lastname, $firstname) {
        $_SESSION["currentUser"] = ['id'=>$id, 'nom'=>$lastname, 'prenom'=>$firstname];
        updateToken($id);
    }

    function createSessionUser($id, $lastname, $firstname) {
        $_SESSION["currentUser"] = ['id'=>$id, 'nom'=>$lastname, 'prenom'=>$firstname];
    }