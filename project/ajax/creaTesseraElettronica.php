<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];

    $status = $dbM->trovaUtente($username, $password);

    echo $status;
?>