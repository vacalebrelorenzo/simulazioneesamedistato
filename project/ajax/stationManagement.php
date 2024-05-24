<?php
    //ws utile alla gestione delle stazioni e del numero di slot

    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $nome = $_GET["nome"];

    if($_GET["operazione"] === "aggiungi")
    {
        $lat = $_GET["lat"];
        $long = $_GET["long"];
        $numSlot = $_GET["num_slot"];

        $citta = $_GET["citta"];
        $via = $_GET["via"];
        $cap = $_GET["cap"];
        $numCiv = $_GET["numCiv"];

        $status = $dbM->stationManagement($nome,$lat, $long,$numSlot,$citta,$via,$cap,$numCiv);
    }
    else if($_GET["operazione"] === "elimina")
        $status = $dbM->rimuoviStazione($nome);
    else if($_GET["operazione"] === "modificaSlot")
        $status = $dbM->modificaSlot($nome,$_GET["newSlot"]);


    echo json_encode($status);
?>