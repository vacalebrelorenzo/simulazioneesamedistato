<?php
    //ws utile a controllare l'username dell'utente
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];
    $email = $_GET["email"];

    //controllo se l'username dell'utente esiste già, se non esiste registro l'utente, se esiste gli richiedo l'username
    $status = $dbM->checkAddUsername($username,$password, $email);
    echo json_encode(array("status" => $status["status"], "information" => $status["information"]));
?>