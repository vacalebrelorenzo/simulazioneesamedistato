<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];
    $email = $_GET["email"];

    //controllo se l'username dell'utente esiste già
    if($dbM->checkUsername($username))
    {    
        //se l'username inserito non esiste si procede con la creazione del cliente
        if($dbM->inserimentoUtente($username, $password, $email))
        {
            //se l'inserimento nel db ha successo, viene creata e associata la smart card al cliente
            if($dbM->trovaUtente($username))
                echo json_encode(array("status" => "ok", "information" => "Registrazione avvenuta con successo!"));
            else
                echo json_encode(array("status" => "error", "information" => "Non è stato possibile associarti ad una smart card!"));
        }
        else
            echo json_encode(array("status" => "error", "information" => "Non è stato possibile registrarti!"));
    } 
    else
        echo json_encode(array("status" => "error", "information" => "L'username esiste di già, cambialo!"));

?>