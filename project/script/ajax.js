$(document).ready(function(){
    $.get("./ajax/get_station_location.php", {} , function (data)
    {
        console.log(data);
        addMarker(data);
    });
}, "json");

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

async function effettuaRegistrazione() {
    // Estrai i valori dai campi del modulo
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
    } else {
        alert("Non è stato possibile portare a termine la registrazione!");
        resettaForm();
    }
}



