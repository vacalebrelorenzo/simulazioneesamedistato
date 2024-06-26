<?php
// Pagina dell'admin
session_start();

if (!isset($_SESSION["username"])) {
    header("location: ../index.html");
    exit(); // Importante per fermare l'esecuzione dello script dopo il redirect
}
?>

<!DOCTYPE html>
<html lang="it"> <!-- Aggiungi il tag di apertura <html> e la lingua -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <script src="../script/jquery-3.7.1.min.js"></script>
    <script src="../script/ajax.js"></script>
    <script src="../script/js.js"></script>
    <script src="../script/adminScript.js"></script>
    
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <span id="utente-login" class="navbar-text ml-auto"><?php echo $_SESSION["username"]; ?></span>
    </nav>

    <div id="start" class="container text-center mt-5">
        <h1 id="title" class="mb-4">Pagina Admin</h1>
        <div id="main-info">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary btn-lg m-2" onclick="caricaFormStazioni()">Opzioni Stazioni</button>
                <button type="button" class="btn btn-primary btn-lg m-2" onclick="caricaFormSlot()">Opzioni Slot</button>
                <button type="button" class="btn btn-primary btn-lg m-2" onclick="caricaFormBiciclette()">Opzioni Biciclette</button>
                <button type="button" class="btn btn-primary btn-lg m-2" onclick="getRichiesteBlocco()">Visualizza Richieste Blocco Smart Cards</button>
            </div>

            <div class="d-flex justify-content-center"> 
                <button type="button" id="btnIndietro" class="btn btn-danger btn-lg m-2" onclick="window.location.href = '../index.html'">Indietro</button>
            </div>
        </div>

        <div id="form-container">
            
        </div>
    </div>
</body>
</html>
