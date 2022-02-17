<?php
function validateZipCodePl($plcode) { 
  if(preg_match("/^([0-9]{2})(-[0-9]{3})?$/i",$plcode)){
    return $error = false;
  } else {
    return $error = true;
    //header("Location: register.php?errorNumber=10");
    //exit();
  }
} 