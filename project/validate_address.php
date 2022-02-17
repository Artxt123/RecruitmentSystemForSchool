<?php
function validateAddress($address){
    if(preg_match("/^[a-z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s\.-]{2,}$/i",$address)){
        return $error = false;
    } else {
        return $error = true;
        //header("Location: register.php?errorNumber=16");
        //exit();
    }
}

function validateHouseNr($house_nr){
    if(preg_match("/^[0-9]{1,3}+([a-z]{1})?$/i",$house_nr)){
        return $error = false;
    } else {
        return $error = true;
        //header("Location: register.php?errorNumber=17");
        //exit();
    }
}

function validateApartmentNr($apartment_nr){
    if(empty($apartment_nr)){
        return $error = false;
    } elseif(preg_match("/^[0-9]{1,3}$/",$apartment_nr)){
        return $error = false;
    } else {
        return $error = true;
        //header("Location: register.php?errorNumber=18");
        //exit();
    }
}