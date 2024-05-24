//script user
$(document).ready(function() {
    let infoUtente = getInfoUtente();
    caricaFormProfilo(infoUtente);
});

//form profilo user
function caricaFormProfilo(infoUtente) {

    let nome = "";
    let cognome = "";
    let numeroCarta = "";
    let username = '<div class="form-group"><label for="username">Username</label><input type="text" id="username" class="form-control" value="'+infoUtente['username']+'"></div>';
    let password = '<div class="form-group"><label for="password">Nuova Password</label><input type="password" id="password" class="form-control""></div>';
    let email = '<div class="form-group"><label for="email">Email</label><input type="text" id="email" class="form-control" value="'+infoUtente["email"]+'"></div>';
    let btnUpdate = '<button type="button" class="btn btn-primary btn-lg btn-block mt-3" onclick="updateInfoUtente()">Update</button>';
    let btnIndietro = '<button type="button" class="btn btn-danger btn-lg btn-block mt-3" onclick="window.location.href=\'../index.html\'">Indietro</button>';

    if(infoUtente["status"] === "error")
    {
        nome = '<div class="form-group"><label for="nome">Nome</label><input type="text" id="nome" class="form-control"></div>';
        cognome = '<div class="form-group"><label for="cognome">Cognome</label><input type="text" id="cognome" class="form-control"></div>';
        numeroCarta = '<div class="form-group"><label for="nCarta">Numero Carta</label><input type="text" id="nCarta" class="form-control"></div>';
    }
    else if(infoUtente["status"] === "ok")
    {
        nome = '<div class="form-group"><label for="nome">Nome</label><input type="text" id="nome" class="form-control" value="'+infoUtente["infoCarta"]["nome"]+'"></div>';
        cognome = '<div class="form-group"><label for="cognome">Cognome</label><input type="text" id="cognome" class="form-control" value="'+infoUtente["infoCarta"]["cognome"]+'"></div>';
        numeroCarta = '<div class="form-group"><label for="nCarta">Numero Carta</label><input type="text" id="nCarta" class="form-control" value="'+infoUtente["infoCarta"]["numero"]+'"></div>';
    }

    $("#form-container").html(username + email + password+ nome + cognome + numeroCarta + btnUpdate + btnIndietro);
}
