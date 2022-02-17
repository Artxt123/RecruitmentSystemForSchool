<?php
session_start();
//JEŻELI NIE JESTEŚ ZALOGOWANY JAKO PRACOWNIK TO NIE WEJDZIESZ TU!
if ((!isset($_SESSION['email'])) || (!isset($_SESSION['employee']))){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>System rekrutacji do szkoły</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        html,
        body {
            height: 100%;
        }
        
        #wrap {
            min-height: 100%;
            height: auto;
            margin: 0 auto -60px;
            padding: 0 0 60px;
        }
        
        #footer {
            /* Ustawienie wysokości stopki */
            height: 60px;
            background-color: #f5f5f5;
        }
        /*Margines wewnątrz stopki */
        
        .container .credit {
            margin: 20px 0;
        }
        
        #footer > .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        @media (min-width: 768px) {
            .navbar .navbar-nav {
                display: inline-block;
                float: none;
                vertical-align: top;
            }
        }
        
        .navbar .navbar-collapse {
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="wrap">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <!-- Grupowanie "marki" i przycisku rozwijania mobilnego menu -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">ZYX Company</a>
                </div>
                <!-- Grupowanie elementów menu w celu lepszego wyświetlania na urządzeniach moblinych -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Oferta <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="direction_matfizinf.php">Mat-fiz-inf</a></li>
                                <li><a href="direction_human.php">Human</a></li>
                                <li><a href="direction_sport.php">Klasa sportowa</a></li>
                                <li><a href="direction_biolchem.php">Biol-chem</a></li>
                            </ul>
                        </li>
                        <li><a href="recruitment_results.php">Rekrutacja</a></li>
                        <li class="active"><a href="database_results.php">Baza danych</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <a class="btn btn-default navbar-btn" href="myaccount.php" role="button">Moje konto</a>
                        <a class="btn btn-primary navbar-btn" href="logout.php" role="button">Wyloguj się</a>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="text-center col-md-12">
                    <?php
                    if(isset($_GET['infoNumber'])){
                        $infoNumber = $_GET['infoNumber'];
                        $infoList[1] = "Aktualizacja danych kandydata przebiegła pomyślnie!";
                        $infoList[2] = "Usunięcie rekordu z kandydatem przebiegło pomyślnie, zostały usunięte również jego dane rekrutacyjne (oceny, punkty, wybory, itd.)!";
                        $infoList[3] = "Aktualizacja danych pracownika przebiegła pomyślnie!";
                        $infoList[4] = "Wprowadzenie danych nowego pracownika przebiegło pomyślnie!";
                        $infoList[5] = "Aktualizacja danych rekrutacyjnych kandydata przebiegła pomyślnie!";
                        $infoList[6] = "Usunięcie danych rekrutacyjnych kandydata przebiegło pomyślnie!";
                        echo "<p class=\"text-success lead\">" . $infoList[$infoNumber] . "</p>";
                    }
                    if(isset($_GET['errorNumber'])){
                        $errorNumber = $_GET['errorNumber'];
                        $errorsList[1] = "BŁĄD! Brak wymaganych parametrów!";
                        $errorsList[2] = "BŁAD! Pobrany id_adres jest nieprawidłowy!";
                        $errorsList[3] = "BŁĄD! Przekazywany adres email jest nieprawidłowy!";
                        $errorsList[3] = "Bład zapytania podczas usuwania danych logowania kandydata!";
                        $errorsList[4] = "Bład zapytania podczas sprawdzania do ilu osób należy adres kandydata!";
                        $errorsList[5] = "Bład zapytania podczas usuwania danych adresowych kandydata!";
                        $errorsList[6] = "Bład zapytania podczas usuwania wyników z egzaminów kandydata!";
                        $errorsList[7] = "BŁAD! Pobrany id_kand jest nieprawidłowy!";
                        $errorsList[8] = "Bład zapytania podczas usuwania ocen kandydata!";
                        $errorsList[9] = "Bład zapytania podczas usuwania uzyskanych punktów przez kandydata!";
                        $errorsList[10] = "Bład zapytania podczas usuwania wybranych kierunków przez kandydata!";
                        echo "<p class=\"text-danger lead\">" . $errorsList[$errorNumber] . "</p>";
                    }
                    ?>
                    <h2>Dane personalne kandydatów:</h2>
                    <p class="text-info">Dane pochodzą z tabel: kandydaci, logowanie, adresy.</p>
                <?php
                include_once("connect.php");
                
                    $query_kandydaci = "SELECT k.ID_KAND, k.IMIE, k.NAZWISKO, k.PLEC, k.DATA_URODZENIA, k.PESEL, k.EMAIL, a.ID_ADRES, a.WOJEWODZTWO, a.MIEJSCOWOSC, a.KOD_POCZTOWY, a.ULICA, a.NR_DOMU, a.NR_MIESZKANIA FROM kandydaci k JOIN adresy a ON k.ID_ADRES=a.ID_ADRES";
                    if ($result = $mysqli->query($query_kandydaci)){
                    
                        if($result->num_rows > 0){
                            
                            echo "<div class=\"table-responsive\">";
                                echo "<table class=\"table table-hover table-striped table-bordered table-condensed\">";
                                    echo "<thead><tr><th>ID_KAND</th><th>IMIE</th><th>NAZWISKO</th><th>PLEC</th><th>DATA_URODZENIA</th><th>PESEL</th><th>EMAIL</th><th>ID_ADRES</th><th>WOJEWODZTWO</th><th>MIEJSCOWOSC</th><th>KOD_POCZTOWY</th><th>ULICA</th><th>NR_DOMU</th><th>NR_MIESZKANIA</th></tr></thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_object()){
                                        echo "<tr>";
                                            echo "<td class=\"info\">" . $row->ID_KAND . "</td>";
                                            echo "<td>" . $row->IMIE . "</td>";
                                            echo "<td>" . $row->NAZWISKO . "</td>";
                                            echo "<td>" . $row->PLEC . "</td>";
                                            echo "<td>" . $row->DATA_URODZENIA . "</td>";
                                            echo "<td>" . $row->PESEL . "</td>";
                                            echo "<td class=\"info\">" . $row->EMAIL . "</td>";
                                            echo "<td class=\"info\">" . $row->ID_ADRES . "</td>";
                                            echo "<td>" . $row->WOJEWODZTWO . "</td>";
                                            echo "<td>" . $row->MIEJSCOWOSC . "</td>";
                                            echo "<td>" . $row->KOD_POCZTOWY . "</td>";
                                            echo "<td>" . $row->ULICA . "</td>";
                                            echo "<td>" . $row->NR_DOMU . "</td>";
                                            echo "<td>" . $row->NR_MIESZKANIA . "</td>";
                                            echo "<td class=\"info\"><a href='edit_candidate.php?email=" . $row->EMAIL . "'>Edytuj</a></td>";
                                            echo "<td class=\"info\"><a href='delete_candidateprocessing.php?email=" . $row->EMAIL . "&id_adres=" . $row->ID_ADRES . "'>Usuń</a></td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                            echo "</div>";
                            
                        } else {
                            echo "Brak rekordów<br>";
                        }
                         $result->close();
                    } else {
                        echo "<p class=\"text-danger\"> Bład zapytania podczas pobierania danych personalnych kandydatów z tabel kandydaci i adresy!</p>";
                    }
                ?>
                <h2>Dane personalne pracowników:</h2>
                    <p class="text-info">Dane pochodzą z tabel: pracownicy, logowanie, adresy.</p>
                    <p class="text-warning">Danego pracownika może usunąć tylko administrator!</p>
                <?php
                
                    $query_pracownicy = "SELECT p.ID_PRAC, p.IMIE, p.NAZWISKO, p.PLEC, p.DATA_URODZENIA, p.PESEL, p.EMAIL, a.ID_ADRES, a.WOJEWODZTWO, a.MIEJSCOWOSC, a.KOD_POCZTOWY, a.ULICA, a.NR_DOMU, a.NR_MIESZKANIA FROM pracownicy p JOIN adresy a ON p.ID_ADRES=a.ID_ADRES";
                    if ($result = $mysqli->query($query_pracownicy)){
                    
                        if($result->num_rows > 0){
                            
                            echo "<div class=\"table-responsive\">";
                                echo "<table class=\"table table-hover table-striped table-bordered table-condensed\">";
                                    echo "<thead><tr><th>ID_PRAC</th><th>IMIE</th><th>NAZWISKO</th><th>PLEC</th><th>DATA_URODZENIA</th><th>PESEL</th><th>EMAIL</th><th>ID_ADRES</th><th>WOJEWODZTWO</th><th>MIEJSCOWOSC</th><th>KOD_POCZTOWY</th><th>ULICA</th><th>NR_DOMU</th><th>NR_MIESZKANIA</th></tr></thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_object()){
                                        echo "<tr>";
                                            echo "<td class=\"info\">" . $row->ID_PRAC . "</td>";
                                            echo "<td>" . $row->IMIE . "</td>";
                                            echo "<td>" . $row->NAZWISKO . "</td>";
                                            echo "<td>" . $row->PLEC . "</td>";
                                            echo "<td>" . $row->DATA_URODZENIA . "</td>";
                                            echo "<td>" . $row->PESEL . "</td>";
                                            echo "<td class=\"info\">" . $row->EMAIL . "</td>";
                                            echo "<td class=\"info\">" . $row->ID_ADRES . "</td>";
                                            echo "<td>" . $row->WOJEWODZTWO . "</td>";
                                            echo "<td>" . $row->MIEJSCOWOSC . "</td>";
                                            echo "<td>" . $row->KOD_POCZTOWY . "</td>";
                                            echo "<td>" . $row->ULICA . "</td>";
                                            echo "<td>" . $row->NR_DOMU . "</td>";
                                            echo "<td>" . $row->NR_MIESZKANIA . "</td>";
                                            echo "<td class=\"info\"><a href='edit_employee.php?email=" . $row->EMAIL . "'>Edytuj</a></td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                            echo "</div>";
                            
                        } else {
                            echo "Brak rekordów<br>";
                        }
                         $result->close();
                    } else {
                        echo "<p class=\"text-danger\"> Bład zapytania podczas pobierania danych personalnych pracowników z tabel pracownicy i adresy!</p>";
                    }
                ?>
                <div><a class="btn btn-link pull-right" href="add_employee.php" role="button">Dodaj pracownika</a></div>
                <h2>Dane rekrutacyjne kandydatów:</h2>
                    <p class="text-info">Dane pochodzą z tabel: kandydaci, egzaminy, oceny, punkty, wybory.</p>
                <?php
                
                    $query_rekrutacja_dane = "SELECT k.ID_KAND, k.IMIE, k.NAZWISKO, p.MAT_FIZ_INF, p.HUMAN, p.SPORT, p.BIOL_CHEM, w.PIERWSZY, w.DRUGI, w.TRZECI, e.POLSKI AS E_POLSKI, e.HISTORIA AS E_HISTORIA, e.MATEMATYKA AS E_MATEMATYKA, e.PRZYRODNICZE, e.OBCY_PODSTAWA, o.POLSKI, o.OBCY, o.HISTORIA, o.MATEMATYKA, o.FIZYKA, o.BIOLOGIA, o.CHEMIA, o.WF, o.PASEK FROM kandydaci k JOIN punkty p ON k.ID_KAND=p.ID_KAND JOIN wybory w ON w.ID_KAND=k.ID_KAND JOIN egzaminy e ON e.ID_KAND=k.ID_KAND JOIN oceny o ON o.ID_KAND=k.ID_KAND";
                    if ($result = $mysqli->query($query_rekrutacja_dane)){
                    
                        if($result->num_rows > 0){
                            
                            echo "<div class=\"table-responsive\">";
                                echo "<table class=\"table table-hover table-striped table-bordered table-condensed\">";
                                    echo "<thead><tr><th>ID_KAND</th><th>IMIE</th><th>NAZWISKO</th><th>PUNKTY MAT-FIZ-INF</th><th>PUNKTY HUMAN</th><th>PUNKTY SPORT</th><th>PUNKTY BIOL_CHEM</th><th>PIERWSZY WYBÓR</th><th>DRUGI WYBÓR</th><th>TRZECI WYBÓR</th><th>POLSKI</th><th>HISTORIA</th><th>MATEMATYKA</th><th>PRZYRODNICZE</th><th>OBCY_PODSTAWA</th><th>POLSKI</th><th>OBCY</th><th>HISTORIA</th><th>MATEMATYKA</th><th>FIZYKA</th><th>BIOLOGIA</th><th>CHEMIA</th><th>WF</th><th>PASEK</th></tr></thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_object()){
                                        echo "<tr>";
                                            echo "<td class=\"info\">" . $row->ID_KAND . "</td>";
                                            echo "<td>" . $row->IMIE . "</td>";
                                            echo "<td>" . $row->NAZWISKO . "</td>";
                                            echo "<td>" . $row->MAT_FIZ_INF . "</td>";
                                            echo "<td>" . $row->HUMAN . "</td>";
                                            echo "<td>" . $row->SPORT . "</td>";
                                            echo "<td>" . $row->BIOL_CHEM . "</td>";
                                            echo "<td>" . $row->PIERWSZY . "</td>";
                                            echo "<td>" . $row->DRUGI . "</td>";
                                            echo "<td>" . $row->TRZECI . "</td>";
                                            echo "<td>" . $row->E_POLSKI . "</td>";
                                            echo "<td>" . $row->E_HISTORIA . "</td>";
                                            echo "<td>" . $row->E_MATEMATYKA . "</td>";
                                            echo "<td>" . $row->PRZYRODNICZE . "</td>";
                                            echo "<td>" . $row->OBCY_PODSTAWA . "</td>";
                                            echo "<td>" . $row->POLSKI . "</td>";
                                            echo "<td>" . $row->OBCY . "</td>";
                                            echo "<td>" . $row->HISTORIA . "</td>";
                                            echo "<td>" . $row->MATEMATYKA . "</td>";
                                            echo "<td>" . $row->FIZYKA . "</td>";
                                            echo "<td>" . $row->BIOLOGIA . "</td>";
                                            echo "<td>" . $row->CHEMIA . "</td>";
                                            echo "<td>" . $row->WF . "</td>";
                                            echo "<td>" . $row->PASEK . "</td>";
                                            echo "<td class=\"info\"><a href='edit_recruitment_data.php?id_kand=" . $row->ID_KAND . "'>Edytuj</a></td>";
                                            echo "<td class=\"info\"><a href='delete_recruitment_dataprocessing.php?id_kand=" . $row->ID_KAND . "'>Usuń</a></td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                            echo "</div>";
                            
                        } else {
                            echo "Brak rekordów<br>";
                        }
                         $result->close();
                    } else {
                        echo "<p class=\"text-danger\"> Bład zapytania podczas pobierania danych rekrutacujnych kandydatów z tabel kandydaci, punkty, wybory, egzaminy, oceny!</p>";
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <p class="text-muted credit">Copyright © 2016 <a href="http://zsp2.krotoszyn.net">ZSP2 Krotoszyn</a>. Design by Artur Oczkowski.</p>
        </div>
    </div>

    <!--jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>