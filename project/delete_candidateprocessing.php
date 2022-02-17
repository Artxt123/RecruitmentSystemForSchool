<?php
session_start();
//JEŻELI NIE JESTEŚ ZALOGOWANY JAKO PRACOWNIK TO URUCHOMISZ TEGO!
if ((!isset($_SESSION['email'])) || (!isset($_SESSION['employee']))){
    header("Location: index.php");
    exit();
}
include_once("connect.php");
include_once("validate_email.php");

if((isset($_GET['email'])) && (isset($_GET['id_adres']))){
    if((is_numeric($_GET['id_adres']))  && ($_GET['id_adres'] > 0)){
        
        //SPRAWDZENIE POPRAWNOŚCI PRZESYŁANEGO ADRESU EMAIL
        if(validateEmail($_GET['email'])){
            header("Location: database_results.php?errorNumber=3");
            exit();
        }
        
        //DODATKOWE SPRAWDZENIE POBIERANYCH DANYCH
        $email = filter_input(INPUT_GET,'email', FILTER_SANITIZE_EMAIL);
        $ID_ADRES = filter_input(INPUT_GET,'id_adres', FILTER_SANITIZE_NUMBER_INT);
        
        
        //JEŻELI PODANY ADRES NALEŻY TYLKO DO TEGO KANDYDATA TO GO USUŃ, JEŻELI NIE TO ZOSTAW GO W BAZIE DANYCH
        
        //SPRAWDZENIE DO ILU OSÓB NALEŻY DANY ADRES ZAMIESZKANIA
        //POLICZENIE KANDYDATÓW Z TAKIM ADRESEM
        if($stmt = $mysqli->prepare("SELECT count(*) FROM adresy a JOIN kandydaci k on a.ID_ADRES=k.ID_ADRES where a.ID_ADRES=?")){
            $stmt->bind_param("i",$ID_ADRES);
            $stmt->execute();
            
            $stmt->bind_result($count_kandydaci);
            $stmt->fetch();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=4");
            exit();
        }
        
        //TERAZ POLICZENIE OSÓB Z TABELI pracownicy Z TAKIM SAMYM ADRESEM
        if($stmt = $mysqli->prepare("SELECT count(*) FROM adresy a JOIN pracownicy p on a.ID_ADRES=p.ID_ADRES where a.ID_ADRES=?")){
            $stmt->bind_param("i",$ID_ADRES);
            $stmt->execute();
            
            $stmt->bind_result($count_pracownicy);
            $stmt->fetch();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=4");
            exit();
        }
        
        //NASTEPNIE DODANIE $count_kandydaci i $count_pracowmnicy,
        //jeżeli wynik wynosi 1 tzn. istnieje tylko jedna osoba w bazie z takim adresem, zatem mogę ten rekord usunąć
        
        /*echo $count_kandydaci."<br>";
        echo $count_pracownicy."<br>";
        echo $count_kandydaci+$count_pracownicy."<br>";
        exit();*/
        
        
        if($count_kandydaci+$count_pracownicy == 1){
            //SKASOWANIE ADRESU KANDYDATA, BO NALEŻY TYLKO DO NIEGO
            $delete_adresy = "DELETE FROM adresy WHERE ID_ADRES = ? LIMIT 1";
            if($stmt = $mysqli->prepare($delete_adresy)){
                $stmt->bind_param("s",$ID_ADRES);
                $stmt->execute();
                $stmt->close();
            } else {
                header("Location: database_results.php?errorNumber=5");
                exit();
            }
        }
        
        //SKASOWANIE DANYCH LOGOWANIA, TABELE SĄ ZE SOBĄ POWIĄZANE, JEŻELI SKASUJĘ E-MIAL KANDYDATA LUB PRACOWNIKA TO ZOSTANĄ USUNIĘTE RÓWNIEŻ JEGO DANE PERSONALNE!
        $delete_logowanie = "DELETE FROM logowanie WHERE EMAIL = ? LIMIT 1";
        if($stmt = $mysqli->prepare($delete_logowanie)){
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: database_results.php?errorNumber=3");
            exit();
        }
   
    } else {
        header("Location: database_results.php?errorNumber=2");
        exit();
    }
} else {
    header("Location: database_results.php?errorNumber=1");
    exit();
}

$mysqli->close();

header("Location: database_results.php?infoNumber=2");
exit();
