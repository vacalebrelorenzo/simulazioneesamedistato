function caricaFormLoginEffettuata()
{
    //TODO: implementa
}

function caricaFormRegistrazione() {
    let title = "<h1>Registrati!</h1>";
    let us = '<input type="text" id="usn" class="form-control" placeholder="Inserisci il tuo username" required>';
    let psw = '<input type="password" id="psw" class="form-control" placeholder="Inserisci la tua password" required>';
    let email = '<input type="email" id="email" class="form-control" placeholder="Inserisci la tua email" required>';
    let citta = '<input type="text" id="citta" class="form-control" placeholder="Inserisci la città" required>';
    let cap = '<input type="number" id="cap" class="form-control" placeholder="Inserisci il CAP" required>';
    let via = '<input type="text" id="via" class="form-control" placeholder="Inserisci la via" required>';
    let numCiv = '<input type="text" id="numCiv" class="form-control" placeholder="Inserisci il civico" required>';
    let btnSubmit = '<button id="registra" class="btn btn-primary btn-block" onclick="effettuaRegistrazione()">Registrati!</button>';
    let btnclose = '<button id="closeReg" class="btn btn-secondary btn-block" onclick="resettaForm()">Indietro</button>';

    $("#form-content").html(title + us + psw + email + citta + cap + via + numCiv + btnSubmit + btnclose);
    $("#start").hide();
    $("#form-container").show();
}

function caricaFormLogin() {
    let title = "<h1>Login!</h1>";
    let us = "<input type='text' id='username' class='form-control' placeholder='Inserisci username!' required>";
    let psw = "<input type='password' id='password' class='form-control' placeholder='Inserisci password!' required>";
    let btnSubmit = "<button type='button' class='btn btn-primary btn-block' onclick='effettuaLogin()'>Login</button>";
    let btnclose = '<button id="closeReg" class="btn btn-secondary btn-block" onclick="resettaForm()">Indietro</button>';


    $("#form-content").html(title + us + psw + btnSubmit + btnclose);
    $("#start").hide();
    $("#form-container").show();
}

function resettaForm() {
    $("#form-content").empty();
    $("#start").show();
    $("#form-container").hide();
}
