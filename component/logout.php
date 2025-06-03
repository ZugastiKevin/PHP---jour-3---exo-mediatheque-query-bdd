<?php
    include('/var/www/html/mediatheque/component/session.php');
    deleteToken($_SESSION['currentUser']['id']);