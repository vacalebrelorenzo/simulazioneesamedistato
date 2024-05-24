<?php
    //ws logout
    if(isset($_SESSION))
    {
        session_unset();
        echo json_encode(array("status"=> "ok", "information" => "logout effettuata!"));
    }
    else
        echo json_encode(array("status"=> "error", "information" => "no logout!"));
?>