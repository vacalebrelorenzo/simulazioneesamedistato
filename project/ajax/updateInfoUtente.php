<?php
    //ws utile ad aggiornare le informazioni del cliente

    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }

    $dbM = new DBManagement();

    $status = $dbM->updateInfoUtente($_GET["username"],$_GET["email"],$_GET["nome"], 
        $_GET["cognome"],$_GET["numeroCarta"], $_SESSION["id_user"], $_SESSION["presenzaCarta"], $_GET["password"]);

    $_SESSION["username"] = $_GET["username"];
    $_SESSION["password"] = $status["password"];

    echo json_encode($status);
?>