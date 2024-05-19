<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $citta = $_GET["citta"];
    $via = $_GET["via"];
    $cap = $_GET["cap"];
    $numCiv = $_GET["numCiv"];

    $status = $dbM->addAddress($username,$citta,$via, $cap, $numCiv);
    echo json_encode(array("status" => $status["status"], "information" => $status["information"]));
?>