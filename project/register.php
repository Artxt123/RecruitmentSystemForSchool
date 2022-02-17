<?php
session_start();
if (isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}?>
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
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <a class="btn btn-default navbar-btn" href="login.php" role="button">Zaloguj się</a>
                        <a class="btn btn-primary navbar-btn active" href="register.php" role="button">Zarejestruj się</a>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <form class="form-horizontal" action="registerprocessing.php" method="POST">
                    <h2 class="form-signin-heading text-center">Rejestracja</h2>
                    <?php
                        if(isset($_GET['errorNumber'])){
                            $errorNumber = $_GET['errorNumber'];
                            $errorsList[1] = "Podany adres email jest nieprawidłowy!";
                            $errorsList[2] = "Podane hasła nie są takie same!";
                            $errorsList[3] = "Podany adres email jest już zajęty!";
                            $errorsList[4] = "Błąd zapytania podczas wprowadzania danych do logowania!";
                            $errorsList[5] = "Błąd zapytania podczas wprowadzania danych adresowych!";
                            $errorsList[6] = "Błąd zapytania podczas pobierania ID_ADRES z tabeli adresy!";
                            $errorsList[7] = "Błąd zapytania podczas wprowadzania danych osobowych!";
                            $errorsList[8] = "Podany numer PESEL jest niepoprawny!";
                            $errorsList[9] = "Podana data urodzenia jest nieprawidłowa!";
                            $errorsList[10] = "Podany kod pocztowy jest nieprawidłowy!";
                            $errorsList[11] = "Podane imię lub nazwisko jest niepoprawne!";
                            $errorsList[12] = "Twoje hasło musi się składać z co najmniej 8 znaków!";
                            $errorsList[13] = "Twoje hasło musi zawierać co najmniej jedną cyfrę!";
                            $errorsList[14] = "Twoje hasło musi zawierać co najmniej jedną wielką literę!";
                            $errorsList[15] = "Twoje hasło musi zawierać co najmniej jedną małą literę!";
                            $errorsList[16] = "Nazwa miejscowości lub ulicy jest nieprawidłowa!";
                            $errorsList[17] = "Numer domu jest nieprawidłowy!";
                            $errorsList[18] = "Numer mieszkania jest nieprawidłowy!";
                            $errorsList[19] = "Twoje hasło musi zawierać co najmniej jeden znak specjalny!";
                            echo "<div ><p class=\"text-danger text-center\">" . $errorsList[$errorNumber] . "</p></div>";
                        }
                    ?>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Adres email" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">Hasło:</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Hasło" required>
                        </div>
                        <label for="inputPassword2" class="col-sm-2 control-label">Powtórz hasło:</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="password2" id="inputPassword2" placeholder="Powtórz hasło" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Imię:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="inputName" placeholder="Imię" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSurname" class="col-sm-2 control-label">Nazwisko:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="surname" id="inputSurname" placeholder="Nazwisko" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-2 control-label"><strong>Płeć:</strong></span>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="genderMale" value="M" required> Mężczyzna
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="genderFemale" value="K" required> Kobieta
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputBirthday" class="col-sm-2 control-label">Data urodzenia:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="birthday" id="inputBirthday" placeholder="RRRR-MM-DD" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPesel" class="col-sm-2 control-label">PESEL:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="pesel" id="inputPesel" placeholder="Twój numer PESEL" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-2 control-label"><strong>Wojewódźtwo:</strong></span>
                        <div class="col-sm-10">
                            <select class="form-control" name="voivodeship" id="inputVoivodeship" required>
                                <option value=> - - Wybierz - - </option>
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
                            <input type="text" class="form-control" name="city" id="inputCity" placeholder="Miejscowość" required>
                        </div>
                        <label for="inputCode" class="col-sm-2 control-label">Kod pocztowy:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="code" id="inputCode" placeholder="00-000" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputStreet" class="col-sm-2 control-label">Ulica:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="street" id="inputStreet" placeholder="Ulica" required>
                        </div>
                        <label for="inputHouseNumber" class="col-sm-2 control-label">Nr domu:</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="house_nr" id="inputHouseNumber" placeholder="00" required>
                        </div>
                        <label for="inputApartmentNumber" class="col-sm-2 control-label">Nr mieszkania:</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" name="apartment_nr" id="inputApartmentNumber" placeholder="00">
                        </div>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block" type="submit">Zarejestruj się</button>
                </form>
            </div>
        </div>
        <!-- /container -->

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