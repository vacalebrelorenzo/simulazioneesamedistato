<?php
    //ws utile ad ottenere tutte le info di un cliente per permettergli di modificarle

    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }

    $dbM = new DBManagement();

    $infoUtente = $dbM->getInfoUtente($_SESSION["username"], $_SESSION["password"]);

    //controllo se l'utente possiede o no una carta registrata
    if(isset($infoUtente["infoCarta"]))
        $_SESSION["presenzaCarta"] = "true";
    else
        $_SESSION["presenzaCarta"] = "false";

    echo json_encode($infoUtente);
?>