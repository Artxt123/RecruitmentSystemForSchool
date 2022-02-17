<?php
function validateDirection($firstchoice,$secondchoice,$thirdchoice){
    if((empty($secondchoice)) && (!empty($thirdchoice)) ){
        return $error = 3;
        /*header("Location: recruitment.php?errorNumber=3");
        exit();*/
    } elseif($firstchoice == $secondchoice || $firstchoice == $thirdchoice){
        return $error = 4;
        /*header("Location: recruitment.php?errorNumber=4");
        exit();*/
    } elseif((!empty($secondchoice)) && (!empty($thirdchoice))){
        if($secondchoice == $thirdchoice){
            return $error = 4;
            /*header("Location: recruitment.php?errorNumber=4");
            exit();*/
        }
    } else {
        return $error = false;;
    }
}