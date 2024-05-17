<?php
    include "../class/DBManagement.php" ;

    $dbM = new DBManagement();

    $username = $_GET["username"];
    $password = $_GET["password"];

    $arr = $dbM->effettuaLogin($username, $password);

	echo json_encode($arr);
?>
