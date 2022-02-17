<?php
session_start();
//JEŻELI NIE JESTEŚ ZALOGOWANY JAKO PRACOWNIK TO URUCHOMISZ TEGO!
if ((!isset($_SESSION['email'])) || (!isset($_SESSION['employee']))){
    header("Location: index.php");
    exit();
}
include_once("connect.php");

if(isset($_GET['id_kand'])){
    if((is_numeric($_GET['id_kand']))  && ($_GET['id_kand'] > 0)){
        
        //DODATKOWE SPRAWDZENIE POBIERANYCH DANYCH
        $ID_KAND = filter_input(INPUT_GET,'id_kand', FILTER_SANITIZE_NUMBER_INT);
        
        //SKASOWANIE DANYCH Z TABELI egzaminy
        $delete_egzaminy = "DELETE FROM egzaminy WHERE ID_KAND = ? LIMIT 1";
        if($stmt = $mysqli->prepare($delete_egzaminy)){
            $stmt->bind_param("i",$ID_KAND);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=6");
            exit();
        }
        
        //SKASOWANIE DANYCH Z TABELI oceny
        $delete_oceny = "DELETE FROM oceny WHERE ID_KAND = ? LIMIT 1";
        if($stmt = $mysqli->prepare($delete_oceny)){
            $stmt->bind_param("i",$ID_KAND);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=8");
            exit();
        }
        
        //SKASOWANIE DANYCH Z TABELI punkty
        $delete_punkty = "DELETE FROM punkty WHERE ID_KAND = ? LIMIT 1";
        if($stmt = $mysqli->prepare($delete_punkty)){
            $stmt->bind_param("i",$ID_KAND);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=9");
            exit();
        }
        
        //SKASOWANIE DANYCH Z TABELI wybory
        $delete_wybory = "DELETE FROM wybory WHERE ID_KAND = ? LIMIT 1";
        if($stmt = $mysqli->prepare($delete_wybory)){
            $stmt->bind_param("i",$ID_KAND);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=10");
            exit();
        }
   
    } else {
        header("Location: database_results.php?errorNumber=7");
        exit();
    }
} else {
    header("Location: database_results.php?errorNumber=1");
    exit();
}

$mysqli->close();

header("Location: database_results.php?infoNumber=6");
exit();
