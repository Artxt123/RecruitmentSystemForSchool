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
                        <li><a href="database_results.php">Baza danych</a></li>
                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <a class="btn btn-default navbar-btn active" href="myaccount.php" role="button">Moje konto</a>
                        <a class="btn btn-primary navbar-btn" href="logout.php" role="button">Wyloguj się</a>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <div class="container">
            
            <?php
            include_once("connect.php");
            $query_pracownicy = "SELECT ID_PRAC, IMIE, NAZWISKO, PLEC, DATA_URODZENIA, PESEL, ID_ADRES FROM pracownicy WHERE EMAIL=? LIMIT 1";
            
            if ($stmt = $mysqli->prepare($query_pracownicy)){
                $stmt->bind_param("s",$_SESSION['email']);
                $stmt->execute();
                
                $stmt->bind_result($ID_PRAC, $name, $surname, $gender, $birthday, $pesel, $ID_ADRES);
                $stmt->fetch();
                $stmt->close();
            } else {
                header("Location: index.php?errorNumber=1");
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
                header("Location: index.php?errorNumber=1");
                exit();
            }
            
            ?>

            <div class="text-center col-md-8 col-md-offset-2">
                <h2>Moje dane:</h2>
            <?php
                if(isset($_GET['infoNumber'])){
                    $infoNumber = $_GET['infoNumber'];
                    $infoList[1] = "Aktualizacja twoich danych przebiegła pomyślnie!";
                    $infoList[2] = "Jesteś pracownikiem, więc nie możesz złożyć podania do rekrutacji!";
                    echo "<p class=\"text-success\">" . $infoList[$infoNumber] . "</p>";
                }
                 if(isset($_GET['errorNumber'])){
                    $errorNumber = $_GET['errorNumber'];
                    $errorsList[1] = "Bład zapytania podczas pobierania danych zakwalifikowanych uczniów. Kierunek Mat-fiz-inf!";
                    $errorsList[2] = "Bład zapytania podczas pobierania danych zakwalifikowanych uczniów. Kierunek Human!";
                    $errorsList[3] = "Bład zapytania podczas pobierania danych zakwalifikowanych uczniów. Kierunek Sport!";
                    $errorsList[4] = "Bład zapytania podczas pobierania danych zakwalifikowanych uczniów. Kierunek Biol-chem!";
                    echo "<p class=\"text-danger\">" . $errorsList[$errorNumber] . "</p>";
                }
            ?>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <form class="form-horizontal" action="" method="">
                    <fieldset disabled>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo $_SESSION['email'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Imię:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" placeholder="<?php echo $name;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSurname" class="col-sm-2 control-label">Nazwisko:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputSurname" placeholder="<?php echo $surname;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-sm-2 control-label"><strong>Płeć:</strong></span>
                            <div class="col-sm-10">
                                <?php
                                if($gender=="M"){?>
                                    <label class="radio-inline">
                                        <input type="radio" id="genderMale" value="M" checked > Mężczyzna
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" id="genderFemale" value="K" > Kobieta
                                    </label>
                                <?php } else {?>
                                    <label class="radio-inline">
                                        <input type="radio" id="genderMale" value="M" > Mężczyzna
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" id="genderFemale" value="K" checked > Kobieta
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputBirthday" class="col-sm-2 control-label">Data urodzenia:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="inputBirthday" value="<?php echo $birthday;?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPesel" class="col-sm-2 control-label">PESEL:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPesel" placeholder="<?php echo $pesel;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-sm-2 control-label"><strong>Wojewódźtwo:</strong></span>
                            <div class="col-sm-10">
                                <select class="form-control" id="inputVoivodeship">
                                    <option value=> <?php echo $voivodeship;?> </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCity" class="col-sm-2 control-label">Miejscowość:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputCity" placeholder="<?php echo $city;?>" >
                            </div>
                            <label for="inputCode" class="col-sm-2 control-label">Kod pocztowy:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputCode" placeholder="<?php echo $code;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputStreet" class="col-sm-2 control-label">Ulica:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputStreet" placeholder="<?php echo $street;?>">
                            </div>
                            <label for="inputHouseNumber" class="col-sm-2 control-label">Nr domu:</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="inputHouseNumber" placeholder="<?php echo $house_nr;?>">
                            </div>
                            <?php
                            
                            if($apartment_nr!=NULL){?>
                            
                            <label for="inputApartmentNumber" class="col-sm-2 control-label">Nr mieszkania:</label>
                            <div class="col-sm-1">
                                <input type="number" class="form-control" name="apartment_nr" id="inputApartmentNumber" placeholder="<?php echo $apartment_nr;?>">
                            </div>
                            
                            <?php } ?>
                            
                        </div>
                    </fieldset>
                    <div><a class="btn btn-link pull-right" href="myaccount_edit.php" role="button">Zmień swoje dane</a></div>
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