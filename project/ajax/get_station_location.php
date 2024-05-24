<?php
    //ws utile ad ottenere le posizioni delle stazioni per i mark sulla mappa
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $vettCoordinate = $dbM->get_station_location();

    echo json_encode($vettCoordinate);
?>