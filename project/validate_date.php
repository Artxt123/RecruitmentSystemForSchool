<?php
function validateDateFormat($date){
  //sprawdzenie formatu daty
  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)){
    
    //sprawdzenie, czy podana data istnieje, czy niepoprawny
    if(checkdate($parts[2],$parts[3],$parts[1])){
      return $error = false;
      } else {
        return $error = true;
        //header("Location: register.php?errorNumber=9");
        //exit();
      }
  } else {
    return $error = true;
    //header("Location: register.php?errorNumber=9");
    //exit();
  }
}