<?php

    $server = 'localhost'; //nazwa serwera
    $user = 'artxt123'; //nazwa użytkownika
    $pass = ''; //hasło tego użytkownika
    $db = 'rekrutacja'; //nazwa bazy danych
    
    $mysqli = new mysqli($server,$user,$pass,$db);
    
    if ($mysqli->connect_error) {
    printf("Connect failed: %s\n", $mysqli->error);
    exit();
    }
    
    $charset = $mysqli->set_charset("utf8");
    
    //Wypisanie, jaki mamy charset    
    //printf("Initial character set: %s\n", $mysqli->character_set_name());