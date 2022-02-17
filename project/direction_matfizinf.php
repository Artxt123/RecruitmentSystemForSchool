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
                        <li><a href="index.php">Home</span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Oferta <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="active"><a href="direction_matfizinf.php">Mat-fiz-inf</a></li>
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
                <h1>Mat-fiz-inf</h1>
            </div>

            

            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <img src="images/mat-fiz-inf-1000.jpg" alt="mat-fiz-inf" class="img-responsive">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1 ">
                    <br><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed ante diam. Aliquam lobortis, eros vitae consectetur rutrum, nisi risus posuere ante, ultricies porta est turpis non nibh. Ut sed eros sit amet sem fringilla luctus. Nullam quis lacus scelerisque odio tristique efficitur. Suspendisse molestie, eros id finibus consectetur, diam metus rutrum ipsum, a porta augue tortor et libero. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce id ligula sem. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                    <br>
                    <h4>Najważniejsze informacje:</h4>
                    <ul><li><strong>Klasa:</strong> 1f</li>
                    <li><strong>Cykl kształcenia: </strong>3 lata.</li>
                    <li><strong>Języki obce: </strong>język angielski, język niemiecki.</li>
                    <li><strong>Przedmioty rozszerzone: </strong>matematyka, fizyka, informatyka.</li>
                    <li><strong>Przedmioty punktowane: </strong>język polski, język obcy, matematyka, fizyka.</li>
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