<?php
session_start();
include_once("connect.php");
include_once("validate_address.php");
include_once("validate_date.php");
include_once("validate_email.php");
include_once("validate_name.php");
include_once("validate_pesel.php");
include_once("validate_zip_code.php");

//SPRAWDZENIE POPRAWNOŚCI PRZESYŁANEGO ADRESU EMAIL
if(validateEmail($_POST['email'])){
    header("Location: myaccount_edit.php?errorNumber=1");
    exit();
}

//SPRAWDZENIE, CZY IMIĘ JEST PRAWIDŁOWE
if(validateName($_POST['name'])){
    header("Location: myaccount_edit.php?errorNumber=8");
    exit();
}

//SPRAWDZENIE, CZY NAZWISKO JEST PRAWIDŁOWE
if(validateName($_POST['surname'])){
    header("Location: myaccount_edit.php?errorNumber=8");
    exit();
}

//SPRAWDZENIE, CZY DATA JEST PRAWIDŁOWA
if(validateDateFormat($_POST['birthday'])){
    header("Location: myaccount_edit.php?errorNumber=9");
    exit();
}

//SPRAWDZENIE, CZY PESEL MA POPRAWNY FORMAT
if(validatePESEL($_POST['pesel'])){
    header("Location: myaccount_edit.php?errorNumber=10");
    exit();
}

//SPRAWDZENIE, CZY NAZWA MIEJSCOWŚCI JEST POPRAWNA
if(validateAddress($_POST['city'])){
    header("Location: myaccount_edit.php?errorNumber=11");
    exit();
}

//SPRAWDZENIE, CZY KOD POCZTOWY JEST POPRAWNY
if(validateZipCodePl($_POST['code'])){
   header("Location: myaccount_edit.php?errorNumber=12");
    exit(); 
}

//SPRAWDZENIE, CZY NAZWA ULICY JEST POPRAWNA
if(validateAddress($_POST['street'])){
    header("Location: myaccount_edit.php?errorNumber=11");
    exit();
}

//SPRAWDZENIE, CZY NUMER DOMU JEST POPRAWNY
if(validateHouseNr($_POST['house_nr'])){
    header("Location: myaccount_edit.php?errorNumber=13");
    exit();
}

//SPRAWDZENIE, CZY NUMER MIESZKANIA JEST POPRAWNY, MOŻE BYĆ PUSTY
if(validateApartmentNr($_POST['apartment_nr'])){
    header("Location: myaccount_edit.php?errorNumber=14");
    exit();
}

//DANE KONTA
$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
//DANE KANDYDATA
$ID_KAND = filter_input(INPUT_POST,'ID_KAND', FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_STRING);
$surname = filter_input(INPUT_POST,'surname', FILTER_SANITIZE_STRING);
$gender = filter_input(INPUT_POST,'gender', FILTER_SANITIZE_STRING);
$birthday = filter_input(INPUT_POST,'birthday', FILTER_SANITIZE_STRING);
$pesel = filter_input(INPUT_POST,'pesel', FILTER_SANITIZE_STRING);
//ADRES KANDYDATA
$ID_ADRES = filter_input(INPUT_POST,'ID_ADRES', FILTER_SANITIZE_NUMBER_INT);
$voivodeship = filter_input(INPUT_POST,'voivodeship', FILTER_SANITIZE_STRING); 
$city = filter_input(INPUT_POST,'city', FILTER_SANITIZE_STRING); 
$code = filter_input(INPUT_POST,'code', FILTER_SANITIZE_STRING); 
$street = filter_input(INPUT_POST,'street', FILTER_SANITIZE_STRING); 
$house_nr = filter_input(INPUT_POST,'house_nr', FILTER_SANITIZE_STRING);
$apartment_nr = filter_input(INPUT_POST,'apartment_nr', FILTER_SANITIZE_NUMBER_INT);

if(empty($apartment_nr)){ $apartment_nr = NULL; }

//AKTUALIZACJA DANYCH W TABELI logowanie
$update_logowanie = "UPDATE logowanie SET EMAIL = ? WHERE EMAIL = ?";

if($stmt = $mysqli->prepare($update_logowanie)){
    $stmt->bind_param("ss",$email,$_SESSION['email']);
    $stmt->execute();
    $_SESSION['email'] = $email;
    $stmt->close();
} else {
    header("Location: myaccount_edit.php?errorNumber=2");
    exit();
}

//AKTUALIZACJA DANYCH W TABELI adresy

//SPRAWDZNIE CZY PRZESYŁANY ADRES SIĘ ZMIENIŁ
$query_compare_adres_data = "SELECT count(*) FROM adresy WHERE ID_ADRES=? AND WOJEWODZTWO=? AND MIEJSCOWOSC=? AND KOD_POCZTOWY=? AND ULICA=? AND NR_DOMU=? AND (NR_MIESZKANIA = ? OR NR_MIESZKANIA IS NULL)";
if($stmt = $mysqli->prepare($query_compare_adres_data)){
    $stmt->bind_param("isssssi",$ID_ADRES,$voivodeship,$city,$code,$street,$house_nr,$apartment_nr);
    $stmt->execute();
        
    $stmt->bind_result($count_adresy);
    $stmt->fetch();
    
    if($count_adresy == 0){
        $changed_adresy = true; //jeżeli nie ma pasujących wierszy tzn. użytkownik dokonał zmian w adresie
    } else {
        $changed_adresy = false; //użytkownik nie dokonał zmian w adresie, zatem nie rozpoczynaj procedury aktualizacji adresu
    }
    
    $stmt->close();
}

if($changed_adresy == true){
    
    // JEŻELI DANY REKORD Z ADRESEM JEST PRZYPISANY DO JEDNEGO UŻYTKOWNIKA W BAZIE DANYCH TO MOGĘ TEN REKORD ZAKTUALIZOWAĆ,
    // JEŻELI TEN REKORD JEST PRZYPISANY DO WIĘKSZEJ ILOŚCI OSÓB TO NIE MOGĘ GO ZAKTUALIZOWAĆ, BO AUTOMATYCZNIE ZMIENIĘ ADRES INNEMU CZŁOWIEKOWI
        // W TAKIM PRZYPDAKU TWORZĘ NOWY REKORD W TABELI adresy
    
    //SPRAWDZENIE, CZY REKORD Z ADRESEM (ID_ADRES) JEST PRZYPISANY TYLKO DO JEDNEJ OSOBY W BAZIE DANYCH
    
    //NAJPIERW POLICZENIE OSÓB Z TABELI kandydaci Z TAKIM SAMYM ADRESEM
    
    if($stmt = $mysqli->prepare("SELECT count(*) FROM adresy a JOIN kandydaci k on a.ID_ADRES=k.ID_ADRES where a.ID_ADRES=?")){
        $stmt->bind_param("i",$ID_ADRES);
        $stmt->execute();
        
        $stmt->bind_result($count_kandydaci);
        $stmt->fetch();
        $stmt->close();
    }
    
    //TERAZ POLICZENIE OSÓB Z TABELI pracownicy Z TAKIM SAMYM ADRESEM
    if($stmt = $mysqli->prepare("SELECT count(*) FROM adresy a JOIN pracownicy p on a.ID_ADRES=p.ID_ADRES where a.ID_ADRES=?")){
        $stmt->bind_param("i",$ID_ADRES);
        $stmt->execute();
        
        $stmt->bind_result($count_pracownicy);
        $stmt->fetch();
        $stmt->close();
    }
    
    //NASTEPNIE DODANIE $count_kandydaci i $count_pracowmnicy,
    //jeżeli wynik wynosi 1 tzn. istnieje tylko jedna osoba w bazie z takim adresem, mogę ten rekord updateować,
    //jeżeli wynik jest inny niż jeden to muszę wprowadzić nowy rekord do tabeli adresy, bo więcej osób w bazie danych posiada ten sam adres.
    
    if($count_kandydaci+$count_pracownicy == 1){
        
        //jeżeli w bazie danych istnieje taki adres który teraz wprowadził użytkownik to nie wpisuj go ponownie tylko zmień ID_ADRES użytkownikowi,
        //w tym celu najpierw wyszukaj czy taki adres w bazie istnieje
        
        
        $query_adresy = "SELECT ID_ADRES FROM adresy WHERE WOJEWODZTWO=? AND MIEJSCOWOSC=? AND KOD_POCZTOWY=? AND ULICA=? AND NR_DOMU=? AND (NR_MIESZKANIA = ? OR NR_MIESZKANIA IS NULL)";
        
        if($stmt = $mysqli->prepare($query_adresy)){
            $stmt->bind_param("sssssi",$voivodeship,$city,$code,$street,$house_nr,$apartment_nr);
            $stmt->execute();
            
            $stmt->bind_result($ID_ADRES_FROM_DATABASE);
            $stmt->fetch();
            //JEŻELI NIE MA TAKIEGO SAMEGO ADRESU W BAZIE TO ZRÓB UPADTE REKORDU WPROWADZAJĄC PODANE DANE
            if (empty($ID_ADRES_FROM_DATABASE)){
                
                $update_adresy = "UPDATE adresy SET WOJEWODZTWO = ?, MIEJSCOWOSC = ?, KOD_POCZTOWY = ?, ULICA = ?, NR_DOMU = ?, NR_MIESZKANIA = ? WHERE ID_ADRES = ?";
    
                if($stmt = $mysqli->prepare($update_adresy)){
                    $stmt->bind_param("sssssii",$voivodeship,$city,$code,$street,$house_nr,$apartment_nr,$ID_ADRES);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    header("Location: myaccount_edit.php?errorNumber=3");
                    exit();
                }
            } 
            //JEŻELI ISTNIEJE W BAZIE DANYCH TO NIE WPORWADZAMY ADRESU DRUGI RAZ TYLKO ZMIENIAMY ID_ADRES W TABELI kandydaci,
            //NASTĘPNIE KASUJEMY REKORD ZE STARYM ADRESEM
            $stmt->close();
        } else {
            header("Location: myaccount_edit.php?errorNumber=5");
            exit();
        }
    
    } else {
        //wprowadzenie nowego adresu do tabeli ta sama procedura co w registerprocessing.php
        //adres może już istenieć w bazie danych, zatem musimy uwzględnić ten przypadek
        //SPRAWDZENIE, CZY PODANY ADRES JUŻ ISTNIEJE W BAZIE DANYCH
        
    //TO SAMO CO W registerprocessing.php
    
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
                    header("Location: myaccount_edit.php?errorNumber=4");
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
                    header("Location: myaccount_edit.php?errorNumber=5");
                    exit();
                }
            } 
            //JEŻELI ISTNIEJE W BAZIE DANYCH TO NIE WPORWADZAMY GO DRUGI RAZ
            $stmt->close();
        } else {
            header("Location: myaccount_edit.php?errorNumber=5");
            exit();
        }
    }
}
//AKTUALIZACJA DANYCH W TABELI kandydaci
$update_kandydaci = "UPDATE kandydaci SET IMIE = ?, NAZWISKO = ?, PLEC = ?, DATA_URODZENIA = ?, PESEL = ?, ID_ADRES = ? WHERE ID_KAND = ?";
if((isset($ID_ADRES_FROM_DATABASE)) && (!empty($ID_ADRES_FROM_DATABASE))){
    //PRZYPADEK 4. PATRZ DÓŁ PLIKU!
    
    //$ID_ADRES_FROM_DATABASE istnieje tylko w przypadku, gdy użytkownik ma swój własny rekord z adresem
        //oraz nie jest pusty, gdy w bazie jest już rekord z takim samym adresem, co podany nowy adres
            //wtedy następuje przypisanie nowego ID_ADRES w tabeli kandydaci oraz skasowanie starego rekordu z adresem z tabeli adresy
                //po to, żeby nie dodawać niepotrzebnie nowego rekordu do tabeli adresy, który będzie miał takie same wartości, co inny już istniejący w tej tabeli (różne będą tylko ID)
    if($stmt = $mysqli->prepare($update_kandydaci)){
        $stmt->bind_param("sssssii",$name,$surname,$gender,$birthday,$pesel,$ID_ADRES_FROM_DATABASE,$ID_KAND);
        $stmt->execute();
        $stmt->close();
    } else {
        header("Location: myaccount_edit.php?errorNumber=6");
        exit();
    }
    
    //SKASOWANIE STAREGO ADRESU Z TABELI adresy, BO W TYM PRZYPADKU NIE JEST JUŻ UŻYWANY PRZEZ NIKOGO
    $delete_adresy = "DELETE FROM adresy WHERE ID_ADRES = ? LIMIT 1";
    if($stmt = $mysqli->prepare($delete_adresy)){
        $stmt->bind_param("i",$ID_ADRES);
        $stmt->execute();
        $stmt->close();
    } else {
        header("Location: myaccount_edit.php?errorNumber=7");
        exit();
    }
    
} else {
    //NORMALNY UPDATE W TABELI kandydaci BEZ USUWANIA STAREGO ADRESU z tabeli adresy
    if($stmt = $mysqli->prepare($update_kandydaci)){
        $stmt->bind_param("sssssii",$name,$surname,$gender,$birthday,$pesel,$ID_ADRES,$ID_KAND);
        $stmt->execute();
        $stmt->close();
    } else {
        header("Location: myaccount_edit.php?errorNumber=6");
        exit();
    }
}
$mysqli->close();

header("Location: myaccount.php?infoNumber=1");
exit();

/*TESTY 
1. PRZYPADEK
Gdy użytkownik współdzieli ten sam adres co inna osoba i zmienia go na inny, którego jeszcze nie ma w bazie danych
WYNIK:
Następuje insert nowego adresu do tabeli adresy oraz update w tabeli kandydaci jego id_adres

2. PRZYPADEK
Gdy użytkownik współdzieli ten sam adres co inna osoba i zmienia go na inny, którego jest już w bazie danych
WYNIK:
Następuje wyszukanie podanego nowego adresu w bazie danych, pobranie jego id (id_adres) oraz przypisanie tego id w tabeli kandydaci w rekordzie tego użytkownika (update id_adres danego użytkownika)

3. PRZYPADEK
Gdy użytkownik ma swój własny rekord z adresem i zmienia swój adres na inny, którego nie ma jeszcze w bazie danych
WYNIK:
Następuje update adresu w tabeli adresy.

4. PRZYPADEK
Gdy użytkownik ma swój własny rekord z adresem i zmienia swój adres na inny, który jest już w bazie danych
WYNIK:
Następuje wyszukanie podanego nowego adresu w bazie danych, pobranie jego id (id_adres) oraz przypisanie tego id w tabeli kandydaci w rekordzie danego użytkownika (update id_adres danego użytkownika)
Następnie skasowanie starego rekordu z poprzednim adresem, bo w tym momencie już nikt go (tego starego adresu) nie używa.


PS To wszystko działa SPRAWDZONE! ;)
*/