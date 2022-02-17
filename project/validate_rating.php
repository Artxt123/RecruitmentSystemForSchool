<?php
function validateRating($rating){
    if($rating >= 2 && $rating <= 6){
        return $error = false;
    } else {
        return $error = true;
        /*header("Location: recruitment.php?errorNumber=1");
        exit();*/
    }
}