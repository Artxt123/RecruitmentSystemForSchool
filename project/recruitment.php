<?php
session_start();
if (!isset($_SESSION['email'])){
    header("Location: login.php?errorNumber=3");
    exit();
}
//JEŻELI JESTEŚ PRACOWNIKIEM TO NIE ZŁOŻYSZ PODANIA...
if (isset($_SESSION['employee'])){
    header("Location: myaccount_employee.php?infoNumber=2");
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
                        <li class="active"><a href="recruitment.php">Rekrutacja</a></li>
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
        
        <?php
            include_once("connect.php");
            $query_kandydaci = "SELECT ID_KAND FROM kandydaci WHERE EMAIL=? LIMIT 1";
            
            if ($stmt = $mysqli->prepare($query_kandydaci)){
                $stmt->bind_param("s",$_SESSION['email']);
                $stmt->execute();
                
                $stmt->bind_result($ID_KAND);
                $stmt->fetch();
                $stmt->close();
            } else {
                header("Location: index.php?errorNumber=1");
                exit();
            }
        ?>
        
        <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <form class="form-horizontal" action="recruitmentprocessing.php" method="POST">
                    <input type="hidden" name="ID_KAND" value="<?php echo $ID_KAND; ?>">
                    <h2 class="form-signin-heading text-center">Rekrutacja</h2>
                    <h3 class="form-signin-heading text-center">Podanie możesz złożyć tylko raz.<br>Jeżeli chcesz zmienić wysłane dane, skontaktuj się z obsługą serwisu.</h3>
                    <?php
                        if(isset($_GET['errorNumber'])){
                            $errorNumber = $_GET['errorNumber'];
                            $errorsList[1] = "Podane oceny muszą być z zakresu 2-6!";
                            $errorsList[2] = "Podane wyniki z egzaminu muszą być z zakresu 0-100%!";
                            $errorsList[3] = "Jeżeli nie wybrałeś drugiego kierunku, nie możesz wybrać trzeciego!";
                            $errorsList[4] = "Nie możesz wybrać dwóch takich samych kierunków!";
                            $errorsList[5] = "Błąd zapytania podczas wprowadzania ocen!";
                            $errorsList[6] = "Błąd zapytania podczas wprowadzania wyników z egzaminów!";
                            $errorsList[7] = "Błąd zapytania podczas wprowadzania wyborów kandydata!";
                            $errorsList[8] = "Błąd podczas przekształcania ocen na punkty! Podałeś złą ocenę!";
                            $errorsList[9] = "Błąd zapytania podczas wprowadzania punktów kandydata!";
                            $errorsList[10] = "Złożyłeś już swoje podanie, aby zmienić podane dane skontaktuj się z obsługą serwisu!";
                            echo "<div ><p class=\"text-danger text-center\">" . $errorsList[$errorNumber] . "</p></div>";
                        }
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="text-center">Podaj swoje oceny:</h3>
                            <div class="form-group">
                                <label for="inputPolish" class="col-sm-5 control-label">Język polski:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="polish" min="2" max="6" id="inputPolish" placeholder="2-6" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputForeign" class="col-sm-5 control-label">Język obcy:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="foreign" min="2" max="6" id="inputForeign" placeholder="2-6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputHistory" class="col-sm-5 control-label">Historia:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="history" min="2" max="6" id="inputHistory" placeholder="2-6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputMaths" class="col-sm-5 control-label">Matematyka:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="maths" min="2" max="6" id="inputMaths" placeholder="2-6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPhysics" class="col-sm-5 control-label">Fizyka:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="physics" min="2" max="6" id="inputPhysics" placeholder="2-6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBiology" class="col-sm-5 control-label">Biologia:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="biology" min="2" max="6" id="inputBiology" placeholder="2-6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputChemistry" class="col-sm-5 control-label">Chemia:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="chemistry" min="2" max="6" id="inputChemistry" placeholder="2-6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPE" class="col-sm-5 control-label">Wychowanie fizyczne:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="pe" min="2" max="6" id="inputPE" placeholder="2-6" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h3 class="text-center">Podaj wyniki z egzaminu gimnazjalnego:</h3>
                            <div class="form-group">
                                <label for="inputExamPolish" class="col-sm-5 control-label">Język polski:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="exampolish" min="0" max="100" id="inputExamPolish" placeholder="0-100%" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExamHistory" class="col-sm-5 control-label">Historia:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="examhistory" min="0" max="100" id="inputExamHistory" placeholder="0-100%" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExamMaths" class="col-sm-5 control-label">Matematyka:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="exammaths" min="0" max="100" id="inputExamMaths" placeholder="0-100%" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExamScience" class="col-sm-5 control-label">Nauki przyrodnicze:</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="examscience" min="0" max="100" id="inputExamScience" placeholder="0-100%" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExamForeign" class="col-sm-5 control-label">Język obcy (poziom podstwowy):</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="examforeign" min="0" max="100" id="inputExamForeign" placeholder="0-100%" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="col-sm-5 control-label"><strong>Świadectwo z&nbsp;wyróżnieniem:</strong></span>
                                <div class="col-sm-7">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="distinction" id="distinctionYes" value="T">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="col-sm-5 control-label"><strong>Pierwszy wybór:</strong></span>
                                <div class="col-sm-7">
                                    <select class="form-control" name="firstchoice" id="inputFirstChoice" required>
                                        <option value=> - - Wybierz - - </option>
                                        <option value="matfizinf">Mat-fiz-inf</option>
                                        <option value="human">Human</option>
                                        <option value="sport">Klasa sportowa</option>
                                        <option value="biolchem">Biol-chem</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="col-sm-5 control-label"><strong>Drugi wybór:</strong></span>
                                <div class="col-sm-7">
                                    <select class="form-control" name="secondchoice" id="inputSecondChoice">
                                        <option value=> - - Wybierz - - </option>
                                        <option value="matfizinf">Mat-fiz-inf</option>
                                        <option value="human">Human</option>
                                        <option value="sport">Klasa sportowa</option>
                                        <option value="biolchem">Biol-chem</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="col-sm-5 control-label"><strong>Trzeci wybór:</strong></span>
                                <div class="col-sm-7">
                                    <select class="form-control" name="thirdchoice" id="inputThirdChoice">
                                        <option value=> - - Wybierz - - </option>
                                        <option value="matfizinf">Mat-fiz-inf</option>
                                        <option value="human">Human</option>
                                        <option value="sport">Klasa sportowa</option>
                                        <option value="biolchem">Biol-chem</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Wyślij dane</button>
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