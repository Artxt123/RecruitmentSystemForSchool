<?php
session_start();
include_once("connect.php");
include_once("rating_to_points.php");
include_once("validate_direction.php");
include_once("validate_exam.php");
include_once("validate_rating.php");

//SPRAWDZENIE, CZY PODANE OCENY SĄ PRAWIDŁOWE
if(validateRating($_POST['polish'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['foreign'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['history'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['maths'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['physics'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['biology'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['chemistry'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateRating($_POST['pe'])){
    header("Location: edit_recruitment_data.php?errorNumber=1&id_kand=" . $_POST['ID_KAND']);
    exit();
}
//SPRAWDZENIE, CZY PODANE WYNIKI Z EGZAMINU MAJĄ POPRAWNY FORMAT
if(validateExam($_POST['exampolish'])){
    header("Location: edit_recruitment_data.php?errorNumber=2&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateExam($_POST['examhistory'])){
    header("Location: edit_recruitment_data.php?errorNumber=2&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateExam($_POST['exammaths'])){
    header("Location: edit_recruitment_data.php?errorNumber=2&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateExam($_POST['examscience'])){
    header("Location: edit_recruitment_data.php?errorNumber=2&id_kand=" . $_POST['ID_KAND']);
    exit();
}
if(validateExam($_POST['examforeign'])){
    header("Location: edit_recruitment_data.php?errorNumber=2&id_kand=" . $_POST['ID_KAND']);
    exit();
}

//SPRAWDZENIE KIERUNKÓW KSZTAŁCENIA
if(validateDirection($_POST['firstchoice'], $_POST['secondchoice'], $_POST['thirdchoice'])){
    $errorNumber = validateDirection($_POST['firstchoice'], $_POST['secondchoice'], $_POST['thirdchoice']);
    header("Location: edit_recruitment_data.php?errorNumber=" . $errorNumber . "&id_kand=" . $_POST['ID_KAND']);
    exit();
}

//DANE KANDYDATA
$ID_KAND = filter_input(INPUT_POST,'ID_KAND', FILTER_SANITIZE_NUMBER_INT);
//OCENY KANDYDATA
$polish = filter_input(INPUT_POST,'polish', FILTER_SANITIZE_NUMBER_INT);
$foreign = filter_input(INPUT_POST,'foreign', FILTER_SANITIZE_NUMBER_INT);
$history = filter_input(INPUT_POST,'history', FILTER_SANITIZE_NUMBER_INT);
$maths = filter_input(INPUT_POST,'maths', FILTER_SANITIZE_NUMBER_INT);
$physics = filter_input(INPUT_POST,'physics', FILTER_SANITIZE_NUMBER_INT);
$biology = filter_input(INPUT_POST,'biology', FILTER_SANITIZE_NUMBER_INT);
$chemistry = filter_input(INPUT_POST,'chemistry', FILTER_SANITIZE_NUMBER_INT);
$pe = filter_input(INPUT_POST,'pe', FILTER_SANITIZE_NUMBER_INT);
//WYNIKI Z EGZAMINU KANDYDATA
$exampolish = filter_input(INPUT_POST,'exampolish', FILTER_SANITIZE_NUMBER_INT); 
$examhistory = filter_input(INPUT_POST,'examhistory', FILTER_SANITIZE_NUMBER_INT); 
$exammaths = filter_input(INPUT_POST,'exammaths', FILTER_SANITIZE_NUMBER_INT); 
$examscience = filter_input(INPUT_POST,'examscience', FILTER_SANITIZE_NUMBER_INT); 
$examforeign = filter_input(INPUT_POST,'examforeign', FILTER_SANITIZE_NUMBER_INT);
//WYBRANE KIERUNKI
$firstchoice = filter_input(INPUT_POST,'firstchoice', FILTER_SANITIZE_STRING);
$secondchoice = filter_input(INPUT_POST,'secondchoice', FILTER_SANITIZE_STRING);
$thirdchoice = filter_input(INPUT_POST,'thirdchoice', FILTER_SANITIZE_STRING);
//ŚWIADECTWO Z WYRÓŻNIENIEM
$distinction = filter_input(INPUT_POST,'distinction', FILTER_SANITIZE_STRING);

if(empty($distinction)){ $distinction = "N"; }
if(empty($secondchoice)){ $secondchoice = NULL; }
if(empty($thirdchoice)){ $thirdchoice = NULL; }

//OCENY NA PUNKTY
$polish_points = ratingToPoints($polish);
$foreign_points = ratingToPoints($foreign);
$history_points = ratingToPoints($history);
$maths_points = ratingToPoints($maths);
$physics_points = ratingToPoints($physics);
$biology_points = ratingToPoints($biology);
$chemistry_points = ratingToPoints($chemistry);
$pe_points = ratingToPoints($pe);
//WYNIKI EGZAMINÓW NA PUNKTY
$exampolish_points = $exampolish*0.2;
$examhistory_points = $examhistory*0.2;
$exammaths_points = $exammaths*0.2;
$examscience_points = $examscience*0.2;
$examforeign_points = $examforeign*0.2;
$exam_points = $exampolish_points + $examhistory_points + $exammaths_points + $examscience_points + $examforeign_points;
//ŚWIADECTWO Z WYRÓŻNIENIEM NA PUNKTY
if($distinction == "T"){
    $distinction_points = 5;
} else {
    $distinction_points = 0;
}

//UPDATE DANYCH W TABELI oceny
$update_oceny = "UPDATE oceny SET POLSKI = ?, OBCY = ?, HISTORIA = ?, MATEMATYKA = ?, FIZYKA = ?, BIOLOGIA = ?, CHEMIA = ?, WF = ?, PASEK = ? WHERE ID_KAND = ?";
if($stmt = $mysqli->prepare($update_oceny)){
    $stmt->bind_param("iiiiiiiisi",$polish,$foreign,$history,$maths,$physics,$biology,$chemistry,$pe,$distinction,$ID_KAND);
    $stmt->execute();
    $stmt->close();
} else {
    header("Location: edit_recruitment_data.php?errorNumber=5&id_kand=" . $_POST['ID_KAND']);
    exit();
}

//UPDATE DANYCH W TABELI egzaminy
$update_egzaminy = "UPDATE egzaminy SET POLSKI = ?, HISTORIA = ?, MATEMATYKA = ?, PRZYRODNICZE = ?, OBCY_PODSTAWA = ? WHERE ID_KAND = ?";
if($stmt = $mysqli->prepare($update_egzaminy)){
    $stmt->bind_param("iiiiii",$exampolish,$examhistory,$exammaths,$examscience,$examforeign,$ID_KAND);
    $stmt->execute();
    $stmt->close();
} else {
    header("Location: edit_recruitment_data.php?errorNumber=6&id_kand=" . $_POST['ID_KAND']);
    exit();
}

//UPDATE DANYCH W TABELI wybory
$update_wybory = "UPDATE wybory SET PIERWSZY = ?, DRUGI = ?, TRZECI = ? WHERE ID_KAND = ?";
if ($stmt = $mysqli->prepare($update_wybory)){
    $stmt->bind_param("sssi",$firstchoice,$secondchoice,$thirdchoice,$ID_KAND);
    $stmt->execute();
    $stmt->close();
} else {
    header("Location: edit_recruitment_data.php?errorNumber=7&id_kand=" . $_POST['ID_KAND']);
    exit();
}


//PRZELICZENIE PUNKTÓW NA WYBRANYCH KIERUNKACH

if($firstchoice == "matfizinf" || $secondchoice == "matfizinf" || $thirdchoice == "matfizinf"){
    //PRZELICZENIE PUNKTÓW
    $rating_points = $polish_points + $foreign_points + $maths_points + $physics_points;
    
    $matfizinf_points = $rating_points + $exam_points + $distinction_points;
} else {
    $matfizinf_points = NULL;
}

if($firstchoice == "human" || $secondchoice == "human" || $thirdchoice == "human"){
    //PRZELICZENIE PUNKTÓW
    $rating_points = $polish_points + $foreign_points + $history_points + $biology_points;
    
    $human_points = $rating_points + $exam_points + $distinction_points;
} else {
    $human_points = NULL;
}

if($firstchoice == "sport" || $secondchoice == "sport" || $thirdchoice == "sport"){
    //PRZELICZENIE PUNKTÓW
    $rating_points = $polish_points + $foreign_points + $pe_points + $biology_points;
    
    $sport_points = $rating_points + $exam_points + $distinction_points;
} else {
    $sport_points = NULL;
}

if($firstchoice == "biolchem" || $secondchoice == "biolchem" || $thirdchoice == "biolchem"){
    //PRZELICZENIE PUNKTÓW
    $rating_points = $polish_points + $foreign_points + $biology_points + $chemistry_points;
    
    $biolchem_points = $rating_points + $exam_points + $distinction_points;
} else {
    $biolchem_points = NULL;
}

/*echo $matfizinf_points."<br>";
echo $human_points."<br>";
echo $sport_points."<br>";
echo $biolchem_points."<br>";*/

//UPDATE DANYCH W TABELI PUNKTY
    $update_punkty = "UPDATE punkty SET MAT_FIZ_INF = ?, HUMAN = ?, SPORT = ?, BIOL_CHEM = ? WHERE ID_KAND = ?";
    if ($stmt = $mysqli->prepare($update_punkty)){
        $stmt->bind_param("ddddi",$matfizinf_points,$human_points,$sport_points,$biolchem_points,$ID_KAND);
        $stmt->execute();
        $stmt->close();
    } else {
        header("Location: edit_recruitment_data.php?errorNumber=9&id_kand=" . $_POST['ID_KAND']);
        exit();
    }

$mysqli->close();

header("Location: database_results.php?infoNumber=5");
exit();