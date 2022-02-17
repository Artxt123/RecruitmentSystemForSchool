<?php

function validatePESEL($nrPESEL){
        $PESELtab= str_split($nrPESEL);
        $countPESEL = count($PESELtab);

        if ($countPESEL != 11){//jeżeli nie ma 11 cyfr to jest niepoprawny
            return $error = true;
            //header("Location: register.php?errorNumber=8");
            //exit();
        }

        //a+3b+7c+9d+e+3f+7g+9h+i+3j+k jeżeli wynik tego wyrażenia jest podzielny przez 10 to PESEL jest poprawny
        $control_sum = $PESELtab[0] + 3*$PESELtab[1] + 7*$PESELtab[2] + 9*$PESELtab[3] + $PESELtab[4] + 3*$PESELtab[5] + 7*$PESELtab[6] + 9*$PESELtab[7] + $PESELtab[8] + 3*$PESELtab[9] + $PESELtab[10];

        if ($control_sum % 10 != 0){
            return $error = true;
            //header("Location: register.php?errorNumber=8");
            //exit();
        }
}

