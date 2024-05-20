<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $vettCoordinate = $dbM->get_station_location();

    echo json_encode($vettCoordinate);
?>