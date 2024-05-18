function effettuaLogin()
{
    let username = $("#username").val();
    let password = $("#password").val();

    $.get("./ajax/login.php", { username: username, password: password }, async function (data) {
        
        console.log(data);
        if(data.status == "ok")
            caricaFormLoginEffettuata();
    } , "json");
}

function effettuaRegistrazione()
{
    let username = $("#usn").val();
    let password = $("#psw").val();
    let email = $("#email").val();

    //TODO: Sviluppo nuova richiesta ajax

    $.get("./ajax/checkUsername.php", {username:username}, async function(data1) {
        console.log("Stato controllo esistenza username ->" + data1); //se data = ok l'username non esiste

        if(data1 === "ok")
        {
            $.get("./ajax/inserisciUtente.php", {username: username, password: password, email:email}, async function (data) {
                console.log("Stato inserimento utente ->" + data);
        
                if(data === "ok")
                {
                    $.get("./ajax/creaTesseraElettronica.php", {username: username, password: password}, async function (data2) {
                        console.log("Stato creazione tessera ->" + data2);

                        resettaForm();
        
                        if(data2 === "ok")
                            alert("Registrazione avvenuta con successo!");
                        else
                            alert("Registrazione non avvenuta!");
                    });
                }
                else
                    alert("Non è stato possibile registrarti!");
            });
        }
        else
        {
            resettaForm();
            alert("Username già utilizzato, scegline un altro!");
        }
    });
}

