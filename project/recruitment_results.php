<?php
session_start();
include_once("connect.php");
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
                        <li class="active"><a href="recruitment_results.php">Rekrutacja</a></li>
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
                <?php
                echo "<h2>Zakwalifikowani Mat-fiz-inf:</h2>";
                $query_matfizinf = "select k.id_kand, k.imie, k.nazwisko, p.mat_fiz_inf, w.pierwszy from kandydaci k join punkty p on k.id_kand=p.id_kand join wybory w on w.id_kand=k.id_kand where w.pierwszy='matfizinf' order by p.mat_fiz_inf desc limit 3";
                if ($result = $mysqli->query($query_matfizinf)){
                
                    if($result->num_rows > 0){
                        
                        echo "<div class=\"table-responsive\">";
                            echo "<table class=\"table table-striped table-bordered\" cellpadding=\"10\">";
                                echo "<thead><tr><th>ID_KAND</th><th>Imię</th><th>Nazwisko</th><th>Punkty</th><th>Pierwszy wybór</th></tr></thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_object()){
                                    echo "<tr>";
                                        echo "<td>" . $row->id_kand . "</td>";
                                        echo "<td>" . $row->imie . "</td>";
                                        echo "<td>" . $row->nazwisko . "</td>";
                                        echo "<td>" . $row->mat_fiz_inf . "</td>";
                                        echo "<td>" . $row->pierwszy . "</td>";
                                        //echo "<td class=\"info\"><a href='records.php?id=" . $row->id . "'>Edytuj</a></td>";
                                        //echo "<td class=\"info\"><a href='delete.php?id=" . $row->id . "'>Usuń</a></td>";
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
                    header("Location: myaccount_employee.php?errorNumber=1");
                    exit();
                }
                
                echo "<h2>Zakwalifikowani Human:</h2>";
                $query_human = "select k.id_kand, k.imie, k.nazwisko, p.human, w.pierwszy from kandydaci k join punkty p on k.id_kand=p.id_kand join wybory w on w.id_kand=k.id_kand where w.pierwszy='human' order by p.human desc limit 3";
                if ($result = $mysqli->query($query_human)){
                
                    if($result->num_rows > 0){
                        
                        echo "<div class=\"table-responsive\">";
                            echo "<table class=\"table table-striped table-bordered\" cellpadding=\"10\">";
                                echo "<thead><tr><th>ID_KAND</th><th>Imię</th><th>Nazwisko</th><th>Punkty</th><th>Pierwszy wybór</th></tr></thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_object()){
                                    echo "<tr>";
                                        echo "<td>" . $row->id_kand . "</td>";
                                        echo "<td>" . $row->imie . "</td>";
                                        echo "<td>" . $row->nazwisko . "</td>";
                                        echo "<td>" . $row->human . "</td>";
                                        echo "<td>" . $row->pierwszy . "</td>";
                                        //echo "<td class=\"info\"><a href='records.php?id=" . $row->id . "'>Edytuj</a></td>";
                                        //echo "<td class=\"info\"><a href='delete.php?id=" . $row->id . "'>Usuń</a></td>";
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
                    header("Location: myaccount_employee.php?errorNumber=2");
                    exit();
                }
                
                echo "<h2>Zakwalifikowani Sport:</h2>";
                $query_sport = "select k.id_kand, k.imie, k.nazwisko, p.sport, w.pierwszy from kandydaci k join punkty p on k.id_kand=p.id_kand join wybory w on w.id_kand=k.id_kand where w.pierwszy='sport' order by p.sport desc limit 3";
                if ($result = $mysqli->query($query_sport)){
                
                    if($result->num_rows > 0){
                        
                        echo "<div class=\"table-responsive\">";
                            echo "<table class=\"table table-striped table-bordered\" cellpadding=\"10\">";
                                echo "<thead><tr><th>ID_KAND</th><th>Imię</th><th>Nazwisko</th><th>Punkty</th><th>Pierwszy wybór</th></tr></thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_object()){
                                    echo "<tr>";
                                        echo "<td>" . $row->id_kand . "</td>";
                                        echo "<td>" . $row->imie . "</td>";
                                        echo "<td>" . $row->nazwisko . "</td>";
                                        echo "<td>" . $row->sport . "</td>";
                                        echo "<td>" . $row->pierwszy . "</td>";
                                        //echo "<td class=\"info\"><a href='records.php?id=" . $row->id . "'>Edytuj</a></td>";
                                        //echo "<td class=\"info\"><a href='delete.php?id=" . $row->id . "'>Usuń</a></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                        echo "</div>";
                        
                    } else {
                        echo "Brak kandydatów z pierwszym wyborem sport<br>";
                        /*$query_sport = "select k.id_kand, k.imie, k.nazwisko, p.sport, w.drugi from kandydaci k join punkty p on k.id_kand=p.id_kand join wybory w on w.id_kand=k.id_kand where w.drugi='sport' order by p.sport desc limit 3";
                        if ($result = $mysqli->query($query_sport)){
                
                            if($result->num_rows > 0){
                                
                                echo "<table class=\"table table-hover table-striped table-bordered\" border=\"1\" cellpadding=\"10\">";
                                    echo "<thead><tr><th>ID_KAND</th><th>Imię</th><th>Nazwisko</th><th>Punkty</th><th>Drugi wybór</th></tr></thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_object()){
                                        echo "<tr>";
                                            echo "<td>" . $row->id_kand . "</td>";
                                            echo "<td>" . $row->imie . "</td>";
                                            echo "<td>" . $row->nazwisko . "</td>";
                                            echo "<td>" . $row->sport . "</td>";
                                            echo "<td>" . $row->drugi . "</td>";
                                            //echo "<td class=\"info\"><a href='records.php?id=" . $row->id . "'>Edytuj</a></td>";
                                            //echo "<td class=\"info\"><a href='delete.php?id=" . $row->id . "'>Usuń</a></td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                echo "</table>";
                                
                            } else {
                                echo "Brak rekordów<br>";
                            }
                        }*/
                    }
                     $result->close();
                } else {
                    header("Location: myaccount_employee.php?errorNumber=3");
                    exit();
                }
                echo "<h2>Zakwalifikowani Biol-chem:</h2>";
                $query_biolchem = "select k.id_kand, k.imie, k.nazwisko, p.biol_chem, w.pierwszy from kandydaci k join punkty p on k.id_kand=p.id_kand join wybory w on w.id_kand=k.id_kand where w.pierwszy='biolchem' order by p.biol_chem desc limit 3";
                if ($result = $mysqli->query($query_biolchem)){
                
                    if($result->num_rows > 0){
                        
                        echo "<div class=\"table-responsive\">";
                            echo "<table class=\"table table-striped table-bordered\" cellpadding=\"10\">";
                                echo "<thead><tr><th>ID_KAND</th><th>Imię</th><th>Nazwisko</th><th>Punkty</th><th>Pierwszy wybór</th></tr></thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_object()){
                                    echo "<tr>";
                                        echo "<td>" . $row->id_kand . "</td>";
                                        echo "<td>" . $row->imie . "</td>";
                                        echo "<td>" . $row->nazwisko . "</td>";
                                        echo "<td>" . $row->biol_chem . "</td>";
                                        echo "<td>" . $row->pierwszy . "</td>";
                                        //echo "<td class=\"info\"><a href='records.php?id=" . $row->id . "'>Edytuj</a></td>";
                                        //echo "<td class=\"info\"><a href='delete.php?id=" . $row->id . "'>Usuń</a></td>";
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
                    header("Location: myaccount_employee.php?errorNumber=4");
                    exit();
                }
                $mysqli->close();
                ?>
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