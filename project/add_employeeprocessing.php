<?php
session_start();
include_once("connect.php");
include_once("validate_address.php");
include_once("validate_date.php");
include_once("validate_email.php");
include_once("validate_name.php");
include_once("validate_password.php");
include_once("validate_pesel.php");
include_once("validate_zip_code.php");

//SPRAWDZENIE POPRAWNOŚCI PRZESYŁANEGO ADRESU EMAIL
if(validateEmail($_POST['email'])){
    header("Location: add_employee.php?errorNumber=1");
    exit();
}

//SPRAWDZENIE, CZY HASŁO SPEŁNIA WYMAGANIA BEZPIECZEŃSTWA
if(validatePassword($_POST['password'],$_POST['password2'])){
    $errorNumber = validatePassword($_POST['password'],$_POST['password2']);
    header("Location: add_employee.php?errorNumber=" . $errorNumber);
    exit();
}

//SPRAWDZENIE, CZY IMIĘ JEST PRAWIDŁOWE
if(validateName($_POST['name'])){
    header("Location: add_employee.php?errorNumber=11");
    exit();
}

//SPRAWDZENIE, CZY NAZWISKO JEST PRAWIDŁOWE
if(validateName($_POST['surname'])){
    header("Location: add_employee.php?errorNumber=11");
    exit();
}

//SPRAWDZENIE, CZY DATA JEST PRAWIDŁOWA
if(validateDateFormat($_POST['birthday'])){
    header("Location: add_employee.php?errorNumber=9");
    exit();
}

//SPRAWDZENIE, CZY PESEL MA POPRAWNY FORMAT
if(validatePESEL($_POST['pesel'])){
    header("Location: add_employee.php?errorNumber=8");
    exit();
}

//SPRAWDZENIE, CZY NAZWA MIEJSCOWŚCI JEST POPRAWNA
if(validateAddress($_POST['city'])){
    header("Location: add_employee.php?errorNumber=16");
    exit();
}

//SPRAWDZENIE, CZY KOD POCZTOWY JEST POPRAWNY
if(validateZipCodePl($_POST['code'])){
    header("Location: add_employee.php?errorNumber=10");
    exit();
}

//SPRAWDZENIE, CZY NAZWA ULICY JEST POPRAWNA
if(validateAddress($_POST['street'])){
    header("Location: add_employee.php?errorNumber=16");
    exit(); 
}

//SPRAWDZENIE, CZY NUMER DOMU JEST POPRAWNY
if(validateHouseNr($_POST['house_nr'])){
    header("Location: add_employee.php?errorNumber=17");
    exit();
}

//SPRAWDZENIE, CZY NUMER MIESZKANIA JEST POPRAWNY
if(validateApartmentNr($_POST['apartment_nr'])){
    header("Location: add_employee.php?errorNumber=18");
    exit();
}

//DANE KONTA
$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING);
$password = password_hash($password, PASSWORD_DEFAULT);
//DANE KANDYDATA
$name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_STRING);
$surname = filter_input(INPUT_POST,'surname', FILTER_SANITIZE_STRING);
$gender = filter_input(INPUT_POST,'gender', FILTER_SANITIZE_STRING);
$birthday = filter_input(INPUT_POST,'birthday', FILTER_SANITIZE_STRING);
$pesel = filter_input(INPUT_POST,'pesel', FILTER_SANITIZE_STRING);
//ADRES KANDYDATA
$voivodeship = filter_input(INPUT_POST,'voivodeship', FILTER_SANITIZE_STRING); 
$city = filter_input(INPUT_POST,'city', FILTER_SANITIZE_STRING); 
$code = filter_input(INPUT_POST,'code', FILTER_SANITIZE_STRING); 
$street = filter_input(INPUT_POST,'street', FILTER_SANITIZE_STRING); 
$house_nr = filter_input(INPUT_POST,'house_nr', FILTER_SANITIZE_STRING);
$apartment_nr = filter_input(INPUT_POST,'apartment_nr', FILTER_SANITIZE_NUMBER_INT);

if(empty($apartment_nr)){ $apartment_nr = NULL; }

//SPRAWDZENIE, CZY E-MAIL JEST WOLNY
if($stmt = $mysqli->prepare("SELECT * FROM logowanie WHERE EMAIL=?")){
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1){
        header("Location: add_employee.php?errorNumber=3");
        exit();
    }
    $stmt->close();
}

//SPRAWDZENIE, CZY PODANY ADRES JUŻ ISTNIEJE W BAZIE DANYCH

$query_adresy = "SELECT ID_ADRES FROM adresy WHERE WOJEWODZTWO=? AND MIEJSCOWOSC=? AND KOD_POCZTOWY=? AND ULICA=? AND NR_DOMU=? AND (NR_MIESZKANIA = ? OR NR_MIESZKANIA IS NULL)";

if($stmt = $mysqli->prepare($query_adresy)){
    $stmt->bind_param("sssssi",$voivodeship,$city,$code,$street,$house_nr,$apartment_nr);
    $stmt->execute();
    
    $stmt->bind_result($ID_ADRES);
    $stmt->fetch();
    //JEŻELI NIE MA ADRESU TO WPROWADŹ GO DO BAZY DANYCH
    if (empty($ID_ADRES)){
        
        $insert_adresy = "INSERT INTO adresy (WOJEWODZTWO, MIEJSCOWOSC, KOD_POCZTOWY, ULICA, NR_DOMU, NR_MIESZKANIA) VALUES (?,?,?,?,?,?)";

        if($stmt = $mysqli->prepare($insert_adresy)){
            $stmt->bind_param("sssssi",$voivodeship,$city,$code,$street,$house_nr,$apartment_nr);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: add_employee.php?errorNumber=5");
            exit();
        }
        //TERAZ POBIERZ ID_ADRES
        if($stmt = $mysqli->prepare($query_adresy)){
            $stmt->bind_param("sssssi",$voivodeship,$city,$code,$street,$house_nr,$apartment_nr);
            $stmt->execute();
            
            $stmt->bind_result($ID_ADRES);
            $stmt->fetch();
            $stmt->close();
        } else {
            header("Location: add_employee.php?errorNumber=6");
            exit();
        }
    } 
    //JEŻELI ISTNIEJE W BAZIE DANYCH TO NIE WPORWADZAMY GO DRUGI RAZ
    $stmt->close();
} else {
    header("Location: add_employee.php?errorNumber=6");
    exit();
}

//WPROWADZENIE DANYCH DO TABELI logowanie
if($stmt = $mysqli->prepare("INSERT INTO logowanie (EMAIL, HASLO) VALUES (?,?)")){
    $stmt->bind_param("ss",$email,$password);
    $stmt->execute();
    $stmt->close();
} else {
    header("Location: add_employee.php?errorNumber=4");
    exit();
}

//WPROWADZENIE DANYCH DO TABELI pracownicy
$insert_pracownicy = "INSERT INTO pracownicy (IMIE, NAZWISKO, PLEC, DATA_URODZENIA, PESEL, EMAIL, ID_ADRES) VALUES (?,?,?,?,?,?,?)";

if ($stmt = $mysqli->prepare($insert_pracownicy)){
    $stmt->bind_param("ssssssi",$name,$surname,$gender,$birthday,$pesel,$email,$ID_ADRES);
    $stmt->execute();
    $stmt->close();
} else {
    header("Location: add_employee.php?errorNumber=7");
    exit();
}

$mysqli->close();

header("Location: database_results.php?infoNumber=4");
exit();