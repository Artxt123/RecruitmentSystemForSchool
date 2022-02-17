<?php
function validateExam($exam){
    if($exam >= 0 && $exam <= 100){
        return $error = false;
    } else {
        return $error = true;
        /*header("Location: recruitment.php?errorNumber=2");
        exit();*/
    }
}