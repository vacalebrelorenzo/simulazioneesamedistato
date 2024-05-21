<?php
    include "../class/DBManagement.php" ;

    if(!isset($_SESSION))
        session_start();

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];

    $_SESSION["username"] = $username;

    $arr = $dbM->effettuaLogin($username, $password);

    $_SESSION["isAdmin"] = $arr["isAdmin"];

	echo json_encode($arr);
?>
