<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $status = $dbM->inserimentoUtente();

    echo $status;

?>