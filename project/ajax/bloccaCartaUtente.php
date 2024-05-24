<?php
    //ws per bloccare la carta di un determinato utente
    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }

    $dbM = new DBManagement();

    $status = $dbM->bloccaSmartCard($_SESSION["username"]);

    echo json_encode($status);
?>