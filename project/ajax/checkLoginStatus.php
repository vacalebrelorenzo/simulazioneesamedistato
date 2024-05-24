<?php
    //controllo se un utente ha già effettuato la login
    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }

    if(isset($_SESSION["username"]))
        echo json_encode(array("status" => "ok", "info" => $_SESSION["username"], "isAdmin" => $_SESSION["isAdmin"]));
    else
        echo json_encode(array("status" => "error", "info" => "undefined", "isAdmin" => "undefined"));
?>