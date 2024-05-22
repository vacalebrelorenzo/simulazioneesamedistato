<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $nome = $_GET["nome"];
    $lat = $_GET["lat"];
    $long = $_GET["long"];
    $numSlot = $_GET["num_slot"];

    $citta = $_GET["citta"];
    $via = $_GET["via"];
    $cap = $_GET["cap"];
    $numCiv = $_GET["numCiv"];

    $status = $dbM->stationManagement($nome,$lat, $long,$numSlot,$citta,$via,$cap,$numCiv);

    echo json_encode($status);

    //Tramite get riceverà anche l'operazione da dover eseguire
    //Gestire anche l'update del numero di slot di una stazione
?>