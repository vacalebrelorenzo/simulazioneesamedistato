<?php
    //ws utile a gestire le biciclette
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    if($_GET["operazione"] === "aggiungi")
        $status = $dbM->aggiungiBici($_GET["nome"], $_GET["kmPercorsi"]);
    else if($_GET["operazione"] === "elimina")
        $status = $dbM->eliminaBici($_GET["id_bici"]);

    echo json_encode($status);
?>