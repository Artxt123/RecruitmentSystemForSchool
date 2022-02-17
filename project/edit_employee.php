<?php
session_start();
//JEŻELI NIE JESTEŚ ZALOGOWANY JAKO PRACOWNIK TO NIE WEJDZIESZ TU!
if ((!isset($_SESSION['email'])) || (!isset($_SESSION['employee']))){
    header("Location: index.php");
    exit();
}
//JEŻELI PRZEKAZYWANY EMAIL TO EMAIL PRACOWNIKA, KTÓRY JEST OBECNIE ZALOGOWANY, TO ODEŚLIJ GO DO JEGO STRONY EDYCJI
if($_SESSION['email'] === $_GET['email']){
    header("Location: myaccount_employee_edit.php");
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
                        <li><a href="recruitment.php">Rekrutacja</a></li>
                        <li><a href="database_results.php">Baza danych</a></li>
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
            <div class="text-center col-md-8 col-md-offset-2">
                <h2>Edytuj dane pracownika:</h2>
            <?php
            include_once("connect.php");
            include_once("validate_email.php");
            
            if(isset($_GET['email'])){
                //SPRAWDZENIE POPRAWNOŚCI PRZESYŁANEGO ADRESU EMAIL
                if(validateEmail($_GET['email'])){
                    echo "<p class=\"text-danger\">BŁĄD! Przekazywany adres email jest nieprawidłowy!</p>";
                    exit();
                }
                
                //DODATKOWE SPRAWDZENIE POBIERANYCH DANYCH
                $email = filter_input(INPUT_GET,'email', FILTER_SANITIZE_EMAIL);
    
                $query_pracownicy = "SELECT ID_PRAC, IMIE, NAZWISKO, PLEC, DATA_URODZENIA, PESEL, ID_ADRES FROM pracownicy WHERE EMAIL=? LIMIT 1";
        
                if ($stmt = $mysqli->prepare($query_pracownicy)){
                    $stmt->bind_param("s",$email);
                    $stmt->execute();
                    
                    $stmt->bind_result($ID_PRAC, $name, $surname, $gender, $birthday, $pesel, $ID_ADRES);
                    $stmt->fetch();
                    $stmt->close();
                } else {
                    echo "<p class=\"text-danger\">Błąd podczas pobierania danych personalnych edytowanego konta!</p>";
                    exit();
                }
                
                $query_adresy = "SELECT WOJEWODZTWO, MIEJSCOWOSC, KOD_POCZTOWY, ULICA, NR_DOMU, NR_MIESZKANIA FROM adresy WHERE ID_ADRES=? LIMIT 1";
            
                if ($stmt = $mysqli->prepare($query_adresy)){
                    $stmt->bind_param("s",$ID_ADRES);
                    $stmt->execute();
                    
                    $stmt->bind_result($voivodeship, $city, $code, $street, $house_nr, $apartment_nr);
                    $stmt->fetch();
                    $stmt->close();
                } else {
                    echo "<p class=\"text-danger\">Błąd podczas pobierania danych adresowych edytowanego konta!</p>";
                    exit();
                }
                
            } else {
                echo "<p class=\"text-danger\">BŁĄD! Brak wymaganych parametrów!</p>";
                exit();
            }
                if(isset($_GET['errorNumber'])){
                    $errorNumber = $_GET['errorNumber'];
                    $errorsList[1] = "Podany adres email jest nieprawidłowy!";
                    $errorsList[2] = "Błąd podczas aktualizacji adresu e-mail";
                    $errorsList[3] = "Błąd podczas aktualizacji danych adresowych";
                    $errorsList[4] = "Błąd zapytania podczas wprowadzania danych adresowych!";
                    $errorsList[5] = "Błąd zapytania podczas pobierania ID_ADRES z tabeli adresy!";
                    $errorsList[6] = "Błąd podczas aktualizacji danych personalnych!";
                    $errorsList[7] = "Błąd podczas usuwania starego adresu!";
                    $errorsList[8] = "Podane imię lub nazwisko jest niepoprawne!";
                    $errorsList[9] = "Podana data urodzenia jest nieprawidłowa!";
                    $errorsList[10] = "Podany numer PESEL jest niepoprawny!";
                    $errorsList[11] = "Nazwa miejscowości lub ulicy jest nieprawidłowa!";
                    $errorsList[12] = "Podany kod pocztowy jest nieprawidłowy!";
                    $errorsList[13] = "Numer domu jest nieprawidłowy!";
                    $errorsList[14] = "Numer mieszkania jest nieprawidłowy!";
                    echo "<p class=\"text-danger\">" . $errorsList[$errorNumber] . "</p>";
                }
            ?>
            </div>
            <div class="col-md-10 col-md-offset-1">
                
                <form class="form-horizontal" action="edit_employeeprocessing.php" method="POST">
                    <input type="hidden" name="ID_PRAC" value="<?php echo $ID_PRAC; ?>">
                    <input type="hidden" name="ID_ADRES" value="<?php echo $ID_ADRES; ?>">
                    <input type="hidden" name="old_email" value="<?php echo $email; ?>">
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputEmail" value="<?php echo $email;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Imię:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="inputName" value="<?php echo $name;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSurname" class="col-sm-2 control-label">Nazwisko:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="surname" id="inputSurname" value="<?php echo $surname;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-2 control-label"><strong>Płeć:</strong></span>
                        <div class="col-sm-10">
                            <?php
                            if($gender=="M"){?>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderMale" value="M" checked > Mężczyzna
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderFemale" value="K" > Kobieta
                                </label>
                            <?php } else {?>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderMale" value="M" > Mężczyzna
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderFemale" value="K" checked> Kobieta
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputBirthday" class="col-sm-2 control-label">Data urodzenia:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="birthday" id="inputBirthday" value="<?php echo $birthday;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPesel" class="col-sm-2 control-label">PESEL:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="pesel" id="inputPesel" value="<?php echo $pesel;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-2 control-label"><strong>Wojewódźtwo:</strong></span>
                        <div class="col-sm-10">
                            <select class="form-control" name="voivodeship" id="inputVoivodeship">
                                <option value="<?php echo $voivodeship;?>"> <?php echo $voivodeship;?> </option>
                                <option value="Dolnośląskie">Dolnośląskie</option>
                                <option value="Kujawsko-pomorskie">Kujawsko-pomorskie</option>
                                <option value="Lubelskie">Lubelskie</option>
                                <option value="Lubuskie">Lubuskie</option>
                                <option value="Łódzkie">Łódzkie</option>
                                <option value="Mazowieckie">Mazowieckie</option>
                                <option value="Małopolskie">Małopolskie</option>
                                <option value="Opolskie">Opolskie</option>
                                <option value="Podkarpackie">Podkarpackie</option>
                                <option value="Podlaskie">Podlaskie</option>
                                <option value="Pomorskie">Pomorskie</option>
                                <option value="Śląskie">Śląskie</option>
                                <option value="Świętokrzyskie">Świętokrzyskie</option>
                                <option value="Warmińsko-mazurskie">Warmińsko-mazurskie</option>
                                <option value="Wielkopolskie">Wielkopolskie</option>
                                <option value="Zachodniopomorskie">Zachodniopomorskie</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputCity" class="col-sm-2 control-label">Miejscowość:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="city" id="inputCity" value="<?php echo $city;?>" >
                        </div>
                        <label for="inputCode" class="col-sm-2 control-label">Kod pocztowy:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="code" id="inputCode" value="<?php echo $code;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputStreet" class="col-sm-2 control-label">Ulica:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="street" id="inputStreet" value="<?php echo $street;?>">
                        </div>
                        <label for="inputHouseNumber" class="col-sm-2 control-label">Nr domu:</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="house_nr" id="inputHouseNumber" value="<?php echo $house_nr;?>">
                        </div>
                       
                        <label for="inputApartmentNumber" class="col-sm-2 control-label">Nr mieszkania:</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" name="apartment_nr" id="inputApartmentNumber" value="<?php echo $apartment_nr;?>">
                        </div>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Zmień dane</button>
                </form>
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