<?php
session_start();
include_once("connect.php");

$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING);

if($stmt = $mysqli->prepare("SELECT EMAIL, HASLO FROM logowanie WHERE EMAIL = ? LIMIT 1")){
    $stmt->bind_param("s",$email);
    $stmt->execute();
    
    $stmt->bind_result($email, $hash);
    $stmt->fetch();
    
    if (password_verify($password, $hash)) {//VARCHAR DO HASŁA 255
        $_SESSION['email'] = $email;
        //header("Location: myaccount.php");
        //exit();
    } else {
        header("Location: login.php?errorNumber=1");
        exit();
    }
    $stmt->close();
} else {
    header("Location: login.php?errorNumber=2");
    exit();
}

//SPRAWDZENIE< CZY JESTEŚ PRACOWNIKIEM
if($stmt = $mysqli->prepare("SELECT * FROM pracownicy WHERE EMAIL = ? LIMIT 1")){
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1){
        $_SESSION['employee'] = true;
    }
    $stmt->close();
} else {
    header("Location: login.php?errorNumber=4");
    exit();
}

if(isset($_SESSION['employee'])){
    header("Location: myaccount_employee.php");
    exit();
} else {
    header("Location: myaccount.php");
    exit();
}
