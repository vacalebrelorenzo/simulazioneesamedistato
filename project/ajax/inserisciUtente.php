<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];
    $email = $_GET["email"];

    $status = $dbM->inserimentoUtente($username, $password, $email);

    echo $status;
?>