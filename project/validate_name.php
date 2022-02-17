<?php
function validateName($name) { 
  if(preg_match("/^[A-ZĆŁÓŚŹŻ]+[a-ząęółśżźćń]+$/",$name)){
    return $error = false;
  } else {
    return $error = true;
    //header("Location: register.php?errorNumber=11");
    //exit();
  }
}