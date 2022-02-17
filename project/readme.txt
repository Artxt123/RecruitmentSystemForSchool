//14.05.2016r.
Odkryty błąd: Przy zmianie danych adresowych jakiegoś człowieka z poziomu panelu pracownika (nie wiem czy z osobistego też),
nie dodaje się numer mieszkania, jeżeli wcześniej go nie było, a pozostały adres tzn. numer domu, kod pocztowy, etc. się nie zmienił. 



Artur Oczkowski klasa IVF nr 14

System rekrutacji dla szkół - sprawozdanie

STAN PROJEKTU - nieskończony. 80%

(Brak osobnych podstron z ofertami kształcenia,
brak wyświetlania kandydatów którzy dostali się na dany kierunek,
brak wyświetlania danych kandydatów i możliwości ich modyfikacji dla pracowników).

connect.php
Połączenie z bazą danych, ustawienie kodowania zanaków na utf8

create_database.sql
Skrypt do utworzenia bazy danych
Stworzenie relacji pomiędzy tabelami. (klucze obce).
Wstawienie przykładowych wartości za pomocą phpmyadmin.
Tabela logowanie - dane logowania dla wszystkich użytkowników.
Tabela adresy - adresy wszystkich użytkowników, pod jednym adresem może mieszkać więcej osób.
Tabele pracownicy, kandydaci - dane pracowników i kandydatów.
Tabele oceny, egzaminy, punkty, wybory - oceny, wyniki z egzaminów, punkty, wybory kierunków poszczególnych kandydatów.

finish.php
Wyświetlenie komunikatu o prawidłowej rejestracji.

index.php
Strona główna, stworzenie szkieletu strony z wykorzystaniem Bootstrap 3.
Górne menu (nav-bar), przyciski, rozwijany przycisk, slider, miniaturki zdjęć danych kierunków, stopka.
Zmiana wyglądu strony wraz ze zmianą rozdzielczości.
Wyświetlanie odpowiedniego menu w zależności, czy jest się zalogowanym, czy nie.

login.php
Podstrona służąca do logowania się, stworzenie formularza, odpowiednie typy pól formularza.
Tylko dla osób, które się jeszcze nie zalogowały, w innym przypdaku przekierowanie do index.php
Wyświetlanie błędów podczas podania złych danych logowania.
Przekierowanie do podstrony myaccount.php po prawidłowej rejestracji.

loginprocessing.php
Kod PHP wykorzystywany do logowania się.
Sprawdzenie, czy e-mail i podane hasło się zgadzają (wykorzystanie metody z hashem dotyczącej hasła).
Filtrowanie danych za pomocą filter_var;  filter_input (PHP >=5.2) zamiast htmlentities.
Jeżeli jesteś pracownikiem zapisanie odpowiednej zmiennej do sesji i przekierowanie do myaccount_employee.php

logout.php
Wylogowanie się tzn. zniszczenie sesji, przekierowanie do strony głównej projektu.

myaccount.php
Dostęp tylko dla zalogowanych kandydatów.
Wyświetlenie komunikatu zachęcającego do złożenia podania, jeżeli kandydat jeszcze tego nie zrobił.
Wyświetlenie danych personalnych bez możliwości ich zmiany.
Jeżeli kandydat chce dokonać zmian odpowiedni link do myaccount_edit.php

myaccount_edit.php
Dostęp tylko dla zalogowanych kandydatów.
Wyświetlenie komunikatu zachęcającego do złożenia podania, jeżeli kandydat jeszcze tego nie zrobił.
Wyświetlenie danych personalnych z możliwością ich zmiany.
Wyświetlanie odpowiednich komunikatów podczas procesu zmiany danych (jeżeli wystąpiły błędy).

myaccount_editprocessing.php
Kod PHP odpowiedzialny za aktualizację danych kandydata.
Walidacja wszystkich podanych danych tak samo jak w registerprocessing.php [patrz niżej registerprocessing.php "Walidacja danych"].
Aktualizacja danych w tabeli logowanie.
Aktualizacj danych w tabeli kandydaci.
Aktualizacja danych w tabeli adresy (4 przypadki).
    Na początku sprawdznie, czy podany adres się zmienił, jeżeli nie to nie aktualizuj danych adresowych.
    
    Sprawdzeni, czy pod podanym adresem mieszka tylko zalogowany kandydat, jeżeli tak to możemy edytować ten rekord, jeżeli nie to musimy dodać nowy rekord z adresem
    lub jeżeli podajem adres który już istnieje w bazie danych to wyszukanie jego ID_ADRES i przypisanie do kandydata.
    
    OPIS WSZYSTKICH PRZYPADKÓW:
    
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
    
Przekierowanie i wyświetlenie odpowiedniego komunikatu po pomyślnym zakończeniu aktualizacji danych.


myaccount_employee.php
Dostęp tylko dla zalogowanych pracowników.
Wyświetlenie danych personalnych bez możliwości ich zmiany.
Jeżeli pracownik chce dokonać zmian odpowiedni link do myaccount_employee_edit.php
Praktycznie to samo, co myaccount.php, występują tylko drobne zmiany interfejsu i inne zapytania do pobrania danych z bazy danych.

myaccount_employee_edit.php
Dostęp tylko dla zalogowanych pracowników.
Wyświetlenie danych personalnych z możliwością ich zmiany.
Wyświetlanie odpowiednich komunikatów podczas procesu zmiany danych (jeżeli wystąpiły błędy).
Praktycznie to samo, co myaccount.php, występują tylko drobne zmiany interfejsu i inne zapytania do pobrania danych z bazy danych.

myaccount_employee_editprocessing.php
Praktycznie to samo co myaccount_editprocessing.php
W tym przypadku dane są aktualizowane w tabeli pracownicy, a nie w tabeli kandydaci.

rating_to_points.php
Funkcja zamieniająca podane oceny podczas składania podania na punkty. 

recruitment.php
Dostęp tylko dla zalogowanych kandydatów.
Formularz służący do podania swoich ocen, wyników z egzaminu, podania informacji o świadectwie z wyróżnieniem, wybrania kierunków kształcenia w odpowiedniej kolejności.

recruitmentprocessing.php
Kod PHP odpowiadający za przesłanie danych kandydata złożonych w podaniu.
Walidacja wszystkich podanych ocen.
Walidacja wszystkich podanych wyników z egzaminów.
Walidacja wybranych kierunków kształcenia.
Filtrowanie danych za pomocą filter_input [patrz niżej na registerprocessing.php]
Jeżeli niewybrane zostały drugi lub trzeci kierunek kształcenia to wstaw NULL.
Sprawdzenie, czy zalogowany kandydat złożył już podanie.
Zamiana ocen na punkty.
Zamiana wyników z egzaminu na punkty.
Zamiana otrzymanego świadectwa z wyróżnieniem na punkty.
Wprowadzenie danych do tabeli oceny.
Wprowadzenie danych do tabeli egzaminy.
Wprowadzenie danych do tabeli wybory.
Przeliczenie zdobytych punktów na wybranych kierunkach,
jeżeli dany kierunek nie został wybran spośród podanych kierunków kształcenia to wstawienie NULL.

Wporwadznie danych do tabeli punkty.
Przekierowanie z odpowiednim komunikatem po poprawnie zakończonej procedurze.

Przekierowywanie z odpowiednim komunikatem, jeżeli wystąpiły błędy podczas procedury przesyłania danych.

recruitment_results_generate.php - nieskńczony (wyświetlenie zakwalifikowanych uczniów na dany kierunek)

register.php

Stworzenie formularza do rejestracji (odpowiednie typy pól oraz wymaganie ich wypełnienia, autofocus po wyświetleniu strony).
Dostęp tylko dla niezalogowanych.
Wyświetlanie błędów, jeżeli proces rejestracji nie przebiega pomyślnie.


registerprocessing.php

Kod PHP odpowiadający za rejestrację.
Walidacja danych:
Sprawdzenie, czy podany adres email jest prawidłowy.
Sprawdzenie, czy podane hasła są takie same, czy spełniają wymgania bezpieczeństwa.
Sprawdzenie, czy imię i nazwisko są poprawne.
Sprawdzenie, czy data urodzenia jest poprawna.
Sprawdzenie, czy PESEL ma poprawny format.
Sprawdzenie, czy nazwa miejscowości jest prawidłowa.
Sprawdzenie, czy nazwa ulicy jest prawidłowa.
Sprawdzenie, czy kod pocztowy jest prawidłowy.
Sprawdzenie, czy numer domu jest prawidłowy.
Sprawdzenie, czy numer mieszkania jest prawidłowy.
Przekierowywanie do register.php (strona rejestracji) i wyświetlanie odpowiednich komunikatów 
o błędach (jeżeli wystąpiły).
Podanie numeru mieszkania nie jest obowiązkowe.
Sprawdzenie, czy email jest wolny.
Sprawdzenie, czy podany adres jest już w bazie danych, jeżeli tak to nie wprowadzaj go ponownie, tylko pobierz odpowiednie ID_ADRES i przypisz użytkownikowi.
Wprowadzanie danych do tabel: adresy, logowanie, kandydaci.
Przekierowanie do finish.php po udanej rejestracji.

Filtrowanie danych za pomocą filter_input (PHP >=5.2), htmlentities wstawiało krzaki do bazy danych (występował problem z przetworzeniem np. litery „ó”).

PLIKI DO WALIDACJI DANYCH

validate_address.php
Walidacja nazwy miejscowości, ulicy.
Walidacja numeru domu.
Walidacja numeru mieszkania.

validate_date.php
Walidacja daty urodzenia.

validate_direction.php
Walidacja wybranych kierunków kształcenia podczas rekrutacji.
Czy wybrane kierunki nie są takie same.
Czy zostały podane w odpowiedniej koljeności (np. nie możesz podać trzeciego, jeżeli nie wybrałeś drugiego)

validate_email.php
Walidacja adresu e-mail.

validate_exam.php
Walidacja podanych wyników z egzaminu.

validate_name.php
Walidacja imienia i nazwiska.

validate_password.php
Walidacja hasła podawanego podczas rejestracji.
Sprawdzenie, czy podane hasła są takie same i czy spełniają odpowiednie wymagania:
min. 8 znaków, min. 1 mała litera, min. 1 wielka litera, min. 1 cyfra, min. 1 znak specjalny.

validate_pesel.php
Sprawdzenie, cyz PESEL ma poprawny format.
Czy składa się z 11 cyfr, czy suma kontrolna się zgadza (czy taki nr PESEL może istnieć).

validate_rating.php
Walidacja podanych ocen podczas rekrutacji.

validate_zip_code.php
Walidacja kodu pocztowego.


BRUDNOPIS!


DODATKOWE DO ZROBIENIA:
1) Sprawdzenie, czy headery działają, szczególnie w myaccount, myaccount_edit i tam gdzie PHP jest razem z HTML,
jeżeli nie to naprawienie albo wypisanie błędu na stronie zamiast headera (szczególnie w myaccount, myaccount_edit, recruitment_results, itp.).


            if((isset($_GET['email'])) && (isset($_GET['id_adres']))){
                if((is_numeric($_GET['id_adres']))  && ($_GET['id_adres'] > 0)){
                    //SPRAWDZENIE POPRAWNOŚCI PRZESYŁANEGO ADRESU EMAIL
                    if(validateEmail($_GET['email'])){
                        echo "<p class=\"text-center text-danger\">BŁĄD! Niepoprawny adres email!</p>";
                        exit();
                    }
                    
                    //DODATKOWE ZABEZPIECZENIE POBIERANYCH DANYCH
                    $email = filter_input(INPUT_GET,'email', FILTER_SANITIZE_EMAIL);
                    $ID_ADRES = filter_input(INPUT_GET,'id_adres', FILTER_SANITIZE_NUMBER_INT);
                    
                    $query_kandydaci = "SELECT ID_KAND, IMIE, NAZWISKO, PLEC, DATA_URODZENIA, PESEL, ID_ADRES FROM kandydaci WHERE EMAIL=? LIMIT 1";
            
                    if ($stmt = $mysqli->prepare($query_kandydaci)){
                        $stmt->bind_param("s",$email);
                        $stmt->execute();
                        
                        $stmt->bind_result($ID_KAND, $name, $surname, $gender, $birthday, $pesel, $ID_ADRES);
                        $stmt->fetch();
                        $stmt->close();
                    } else {
                        header("Location: index.php?errorNumber=1");
                        exit();
                    }
                    
                    
                    
                } else {
                    echo "<p class=\"text-center text-danger\">BŁĄD! Niepoprawne id_adres!</p>";
                    exit();
                }
            } else {
                echo "<p class=\"text-center text-danger\">BŁĄD! Brak wymaganych parametrów!</p>";
                exit();
            }
            
            
INSERT INTO `kandydaci` (`ID_KAND`, `IMIE`, `NAZWISKO`, `PLEC`, `DATA_URODZENIA`, `PESEL`, `EMAIL`, `ID_ADRES`) VALUES
(14, 'Marcin', 'Duda', 'M', '2000-06-06', '00260611879', 'marcind@o2.pl', 16),
(15, 'Daria', 'Duda', 'K', '2000-06-06', '00260613888', 'dariad@o2.pl', 16),
(16, 'Marta', 'Nowak', 'K', '2001-06-06', '01260601965', 'martan@o2.pl', 17),
(47, 'Marek', 'Cepa', 'M', '2000-06-19', '00261908972', 'marekc@o2.pl', 42),
(48, 'Jarosław', 'Nowak', 'M', '2000-09-12', '00291205317', 'jarekc@o2.pl', 42);