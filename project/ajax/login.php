<?php
    //ws per login e salva informazioni utili per altre funzionalità
    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];

    $_SESSION["username"] = $username;

    $arr = $dbM->effettuaLogin($username, $password);

    $_SESSION["isAdmin"] = $arr["isAdmin"];
    $_SESSION["id_user"] = $arr["id_user"];

    if($arr["status"] === "ok")
        $_SESSION["password"] = $password;

	echo json_encode($arr);
?>
