<?php
function ratingToPoints($subject){
    switch ($subject) {
    case 6:
        return $subject_points = 20;
        break;
    case 5:
        return $subject_points = 16;
        break;
    case 4:
        return $subject_points = 12;
        break;
    case 3:
        return $subject_points = 8;
        break;
    case 2:
        return $subject_points = 2;
        break;
    default:
        header("Location: index.php?errorNumber=2");
        exit();
        break;
    }
}
