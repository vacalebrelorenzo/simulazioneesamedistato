function getStationLocation()
{
    $.get("./ajax/get_station_location.php", {} , function (data)
    {
        console.log(data);
        addMarker(data);
    }, "json");
}

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
                $("#btnLogout").css("display", "block");
                chiudiBtnFormMain();
                resettaForm();
            }
        }
        else
        {
            alert(data.information);
        }    
    } , "json");
}

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
        chiudiAdmin();
    } else {
        alert("Non è stato possibile portare a termine la registrazione!");
        resettaForm();
        chiudiAdmin();
    }
}

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

    $.get("../ajax/stationManagement.php", { nome: nome, lat: lat, long:long, num_slot: num_slot, citta:citta, via:via, cap:cap, numCiv:numCiv}, function (data) {
        console.log(data);
    } , "json");
}

function eliminaStazione()
{


}

function modificaSlot()
{

}

function aggiungiBicicletta()
{

}

function rimuoviBicicletta()
{

}

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

function caricaAdminInfo() {
    $("#btnAdmin").css("display", "block");
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
}