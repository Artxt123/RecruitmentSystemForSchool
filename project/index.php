<?php
session_start();
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
        
        h3 a:link,
        h3 a:visited {
            text-decoration: none;
            color: white;
        }
        .second-slider-text{
            font-weight: bold;
            color:#000000;
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
                        <li class="active"><a href="index.php">Home</span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Oferta <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="direction_matfizinf.php">Mat-fiz-inf</a></li>
                                <li><a href="direction_human.php">Human</a></li>
                                <li><a href="direction_sport.php">Klasa sportowa</a></li>
                                <li><a href="direction_biolchem.php">Biol-chem</a></li>
                            </ul>
                        </li>
                        <?php
                        if(isset($_SESSION['employee'])){ ?>
                            <li><a href="recruitment_results.php">Rekrutacja</a></li>
                            <li><a href="database_results.php">Baza danych</a></li>
                        <?php
                        } else { ?>
                        <li><a href="recruitment.php">Rekrutacja</a></li>
                        <?php } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                        if(isset($_SESSION['email'])){
                        ?>
                            <a class="btn btn-default navbar-btn" href="myaccount.php" role="button">Moje konto</a>
                            <a class="btn btn-primary navbar-btn" href="logout.php" role="button">Wyloguj się</a>
                        <?php
                        } else { ?>
                        <a class="btn btn-default navbar-btn" href="login.php" role="button">Zaloguj się</a>
                        <a class="btn btn-primary navbar-btn" href="register.php" role="button">Zarejestruj się</a>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <div class="container">
            <!--Tekst nagłówka-->
            <div class="page-header text-center">
                <h1>Witamy w systemie rekrutacyjnym ZYX</h1>
            <?php
                if(isset($_GET['errorNumber'])){
                    $errorNumber = $_GET['errorNumber'];
                    $errorsList[1] = "Błąd podczas pobierania danych Twojego konta!";
                    $errorsList[2] = "Błąd podczas przekształcania ocen na punkty! Podałeś złą ocenę!";
                    echo "<p class=\"text-danger\">" . $errorsList[$errorNumber] . "</p>";
                }
            ?>
            </div>

            <!-- Slider START -->
            <div class="col-md-10 col-md-offset-1">
                <div id="carousel-example-generic2" class="carousel slide">
                    <!-- Wskaźniki w postaci kropek -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic2" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic2" data-slide-to="1"></li>
                    </ol>

                    <!-- Slajdy -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="images/rejestracja.jpg" alt="zarejestruj się">
                            <!-- Opis slajdu -->
                            <div class="carousel-caption">
                                <h3><a href="register.php">Zarejestruj się</a></h3>
                                <p>Nie czekaj zanim inni Cię wyprzedzą!</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="images/start.jpg" alt="Start rekrutacji">
                            <!-- Opis slajdu -->
                            <div class="carousel-caption">
                                <h3 class="second-slider-text">STARTUJEMY 23 maja!</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Strzałki do przewijania -->
                    <a class="left carousel-control" href="#carousel-example-generic2" data-slide="prev">
                        <span class="icon-prev"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic2" data-slide="next">
                        <span class="icon-next"></span>
                    </a>
                </div>
            </div>
            <!-- Slider END -->

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-center">KIERUNKI KSZTAŁECENIA</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-2 col-sm-6">
                    <div class="thumbnail">
                        <img src="images/mat-fiz-inf.jpg" alt="mat-fiz-inf">
                        <div class="caption">
                            <h3>Mat-fiz-inf</h3>
                            <p>Jeden z najbardziej męskich kierunków.
                                <br>Tylko dla prawdziwych twardzieli!</p>
                            <p><a href="direction_matfizinf.php" class="btn btn-primary" role="button">Zobacz</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <img src="images/human.jpg" alt="human">
                        <div class="caption">
                            <h3>Human</h3>
                            <p>Kochasz literaturę, histrorię itp.? A może nie lubisz liczyć? Ten kierunek jest dla Ciebie!</p>
                            <p><a href="direction_human.php" class="btn btn-default" role="button">Zobacz</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 col-sm-6">
                    <div class="thumbnail">
                        <img src="images/sport.jpg" alt="sport">
                        <div class="caption">
                            <h3>Klasa sportowa</h3>
                            <p>Sport to zdrowie! Bądź jak Lewandowski albo jak pani na zdjęciu. (Nie, nie musisz być czarny)</p>
                            <p><a href="direction_sport.php" class="btn btn-primary" role="button">Zobacz</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <img src="images/biol-chem.jpg" alt="biol-chem">
                        <div class="caption">
                            <h3>Biol-chem</h3>
                            <p>Wybierz ten kierunek, zostań lekarzem i zarabiaj ile chcesz!</p>
                            <p><a href="direction_biolchem.php" class="btn btn-default" role="button">Zobacz</a></p>
                        </div>
                    </div>
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