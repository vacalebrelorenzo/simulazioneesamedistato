<?php
    //ws per ottenere tutte le richieste di blocco
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $info = $dbM->getRichiesteBlocco();

    echo json_encode($info);
?>