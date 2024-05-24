<?php
    //Pagina User
    if(!isset($_SESSION))
    {
        ini_set('session.cookie_lifetime', 0); 
        session_start();
    }
    if(!isset($_SESSION["username"]))
        header("location: ../index.html");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>

    <link rel="stylesheet" href="../style/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script src="../script/jquery-3.7.1.min.js"></script>
    <script src="../script/ajax.js"></script>
    <script src="../script/js.js"></script>
    <script src="../script/userScript.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <span id= "utente-login" class="navbar-text ml-auto "> <?php echo $_SESSION["username"]; ?></span>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="form-container" class="p-4 bg-white rounded shadow-sm">

                </div>
            </div>
        </div>
    </div>
</body>
</html>
