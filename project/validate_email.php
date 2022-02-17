<?php
function validateEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return $error = true;
    //header("Location: register.php?errorNumber=1");
    //exit();
    }
}