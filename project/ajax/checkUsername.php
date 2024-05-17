<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];

    $status = $dbM->checkUsername($username);

    echo $status;

?>