<?php
    //ws per creare una nuova smart card per l'utente
    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }

    $dbM = new DBManagement();

    $status = $dbM->gestioneNuovaSC($_GET["id_utente"]);

    echo json_encode($status);
?>