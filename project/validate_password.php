<?php
function validatePassword($password,$password2){
    if ($password != $password2){
        return $error = 2;
        /*header("Location: register.php?errorNumber=2");
        exit();*/
    } elseif (strlen($password) < '8') {
        return $error = 12;
        /*header("Location: register.php?errorNumber=12");
        exit();*/
    } elseif(!preg_match("#[0-9]+#",$password)) {
        return $error = 13;
        /*header("Location: register.php?errorNumber=13");
        exit();*/
    } elseif(!preg_match("#[A-Z]+#",$password)) {
        return $error = 14;
        /*header("Location: register.php?errorNumber=14");
        exit();*/
    } elseif(!preg_match("#[a-z]+#",$password)) {
        return $error = 15;
        /*header("Location: register.php?errorNumber=15");
        exit();*/
    } elseif(!preg_match("#[\W]+#",$password)) {
        return $error = 19;
        /*header("Location: register.php?errorNumber=19");
        exit();*/
    } else {
        return $error = false;
    }
}