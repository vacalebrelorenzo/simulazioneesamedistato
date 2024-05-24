//Richieste ajax

//richiesta posizioni 
function getStationLocation()
{
    $.get("./ajax/get_station_location.php", {} , function (data)
    {
        console.log(data);
        addMarker(data);
    }, "json");
}

//richiesta login
function effettuaLogin()
{
    let username = $("#username").val();
    let password = $("#password").val();

    $.get("./ajax/login.php", { username: username, password: password }, function (data) {
        console.log(data);
        if(data.status === "ok") {
            $("#utente-login").text(username);
            if(data.isAdmin === 1)
            {
                caricaAdminInfo();
                resettaForm();
            }
            else
            {
                caricaUserInfo();
                resettaForm();
            }
        }
        else
        {
            alert(data.information);
        }    
    } , "json");
}

//richiesta per registrazione
async function effettuaRegistrazione() {
    let username = $("#usn").val();
    let password = $("#psw").val();
    let email = $("#email").val();
    let citta = $("#citta").val();
    let via = $("#via").val();
    let cap = $("#cap").val();
    let numCiv = $("#numCiv").val();

    let response = await $.get("./ajax/checkAddUser.php", { username, password, email });
    let data = JSON.parse(response);
    console.log(data);

    if (data.status === "ok") {
        let response2 = await $.get("./ajax/addAddress.php", { username, citta, via, cap, numCiv });
        let data2 = JSON.parse(response2);
        console.log(data2);
        alert(data.information); 
        resettaForm();
        chiudiAdminInfo();
    } 
    else 
    {
        alert("Non è stato possibile portare a termine la registrazione!");
        resettaForm();
        chiudiAdminInfo();
    }
}

//richiesta per aggiungere stazione
function aggiungiStazione()
{
    let nome = $("#station-name-add").val();
    let lat = $("#station-lat").val();
    let long = $("#station-long").val();
    let num_slot = $("#num-slot").val();

    let citta = $("#citta").val();
    let via = $("#via").val();
    let cap = $("#cap").val();
    let numCiv = $("#numCiv").val();

    let operazione = "aggiungi";

    $.get("../ajax/stationManagement.php", { nome: nome, lat: lat, long:long, num_slot: num_slot, citta:citta, via:via, cap:cap, numCiv:numCiv, operazione: operazione}, function (data) {
        console.log(data);
        alert(data["information"]);
        if(data.status === "ok")
            chiudi();
    } , "json");
}

//richiesta per eliminare stazione
function eliminaStazione()
{
    let nome = $("#station-name-remove").val();
    let operazione = "elimina";

    $.get("../ajax/stationManagement.php", {nome: nome, operazione: operazione}, function (data) {
        console.log(data);
        alert(data["information"]);
        if(data.status === "ok")
            chiudi();
    } , "json");
}

//richiesta per modificare il numero di uno slot
function modificaSlot()
{
    let nome = $("#station-name-mod").val();
    let newSlot = $("#new-slot-mod").val();
    let operazione = "modificaSlot";

    $.get("../ajax/stationManagement.php", {nome: nome, newSlot:newSlot, operazione: operazione}, function (data) {
        console.log(data);
        alert(data["information"]);
        if(data.status === "ok")
            chiudi();
    } , "json");
}

//richiesta per aggiungere una bicicletta
function aggiungiBicicletta()
{
    let nome = $("#station-name").val();
    let kmPercorsi = $("#kmTot").val();
    let operazione = "aggiungi";

    $.get("../ajax/bicicleManagement.php", {nome: nome, kmPercorsi:kmPercorsi, operazione: operazione}, function (data) {
        console.log(data);
        alert(data["information"]);
        if(data.status === "ok")
            chiudi();
    } , "json");
}

//richiesta per rimuovere una bicicletta
function rimuoviBicicletta()
{
    let id_bici = $("#id_bici").val();
    let operazione = "elimina";

    $.get("../ajax/bicicleManagement.php", {id_bici: id_bici, operazione: operazione}, function (data) {
        console.log(data);
        alert(data["information"]);
        if(data.status === "ok")
            chiudi();
    } , "json");
}

//richiesta per ottenere le info di un utente
function getInfoUtente()
{
    $.get("../ajax/getInfoUtente.php", {}, function (data) {
        console.log(data);
        caricaFormProfilo(data);
    } , "json");
}

//richiesta per aggiornare le info dell'utente 
function updateInfoUtente()
{
    let username = $("#username").val();
    let email = $("#email").val();
    let nome = $("#nome").val();
    let cognome = $("#cognome").val();
    let numeroCarta = $("#nCarta").val();
    let password = $("#password").val();

    $.get("../ajax/updateInfoUtente.php", {username: username, email: email, nome: nome, cognome: cognome, numeroCarta:numeroCarta, password:password}, function (data) {
        console.log(data);
        alert(data.information)
        window.location.href = "../index.html";

    } , "json");
}

//richiesta per controllare se qualcuno ha già fatto una login
function checkLoginStatus()
{
    $.get("ajax/checkLoginStatus.php", {}, function (data) {
        if(data.status === "ok")
        {
            if(data.isAdmin === 1)
            {
                $("#utente-login").text(data.info);
                caricaAdminInfo();
                resettaForm();
            }
            else
            {
                $("#utente-login").text(data.info);
                caricaUserInfo();
                resettaForm();
            }
        }
    } , "json");
}

//logout
function logout()
{
    $("#utente-login").text("Accesso non effettuato");

    $.get("./ajax/logout.php", {} , function (data)
    {
        console.log(data);
    }, "json");

    apriBtnFormMain();
    chiudiAdminInfo();
}



//Funzioni utili alla visualizzazione grafica dell'index

function caricaAdminInfo() {
    $("#btnAdmin").css("display", "block");
    $("#btnLogout").css("display", "block");
    chiudiBtnFormMain();
}

function caricaUserInfo()
{
    $("#btnUser").css("display", "block");
    $("#btnLogout").css("display", "block");
    chiudiBtnFormMain();
}

function chiudiAdminInfo()
{
    $("#btnAdmin").css("display", "none");
    $("#btnLogout").css("display", "none");
}

function chiudiBtnFormMain()
{
    $("#btnFormlog").css("display", "none");
    $("#btnFormReg").css("display", "none");
}

function apriBtnFormMain()
{
    $("#btnFormlog").css("display", "block");
    $("#btnFormReg").css("display", "block");
    $("#btnUser").css("display", "none");
}