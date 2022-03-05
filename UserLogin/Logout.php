<?php
    session_start();
    session_unset();
    if (isset($_COOKIE['rememberUserCookie'])) {
        unset($_COOKIE['rememberUserCookie']);
    }
    setcookie("rememberUserCookie", NULL , time() - 60);
    session_destroy();
    header("Location:Login.php");
 ?>   
