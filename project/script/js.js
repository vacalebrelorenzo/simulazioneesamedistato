function caricaFormRegistrazione()
{
    let us = '<br><input type="text" id="usn" placeholder="inserisci il tuo username" required> <br>'
    let psw = '<input type="password" id="psw" placeholder="inserisci la tua password" required> <br>';
    let email = '<input type="text" id="email" placeholder="inserisci la tua email" required> <br>';
    let btnSubmit = '<button id="registra" onclick="effettuaRegistrazione()">Registrati!</button>';
    let btnclose= '<button id="closeReg" onclick="resettaFormRegistrazione()">Chiudi!</button>';

    $("#reg-container").append(us);
    $("#reg-container").append(psw);
    $("#reg-container").append(email);
    $("#reg-container").append(btnSubmit);
    $("#reg-container").append(btnclose);

    $("#btnFormReg").hide();
}

function resettaFormRegistrazione()
{
    $("#reg-container").text("");
    $("#btnFormReg").show();
}