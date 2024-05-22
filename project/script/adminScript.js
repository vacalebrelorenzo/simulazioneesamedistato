function caricaFormStazioni() {
    
    $("#title").text("Stazioni");

    //aggiungi
    let nome = '<input type="text" id="station-name-add" style = "width: 100%;" placeholder="inserisci il nome della stazione" required>';
    let lat = '<input type="text" id="station-lat" style = "width: 100%;" placeholder="inserisci la latitudine" required>';
    let long = '<input type="text" id="station-lon" style = "width: 100%;" placeholder="inserisci la longitudine" required>';
    let numSlot = '<input type="text" id="num-slot" style = "width: 100%;" placeholder="inserisci il numero di slot" required>';
    let citta = '<input type="text" id="citta" style = "width: 100%; class="form-control" placeholder="Inserisci la città" required>';
    let cap = '<input type="text" id="cap" style = "width: 100%;class="form-control" placeholder="Inserisci il CAP" required>';
    let via = '<input type="text" id="via" style = "width: 100%; class="form-control" placeholder="Inserisci la via" required>';
    let numCiv = '<input type="text" id="numCiv" style = "width: 100%; class="form-control" placeholder="Inserisci il civico" required>';
    let btnAggiungi = '<button type="button" id="btnAggiungiStazione" class="btn btn-primary btn-lg m-2" onclick = "aggiungiStazione()">Aggiungi</button>';
  
    //elimina
    let nomeElim = '<input type="text" id="station-name-remove" style = "width: 100%;" placeholder="inserisci il nome della stazione" required>';
    let btnElimina = '<button type="button" id="btnEliminaStazione" class="btn btn-primary btn-lg m-2" style="background-color: rgb(168, 4, 4); border-color: rgb(138, 2, 2);" onclick = "eliminaStazione()">Elimina</button>';
  
    let btnChiudi = '<button type="button" class="btn btn-secondary btn-lg m-2" onclick = "chiudi()">Chiudi</button>';
  
    $("#form-container").html('<div class="row">' +
      '<div class="col-6">' +
        "<h2 style = 'color:white;'>Aggiungi</h2>" + nome + lat + long + numSlot + citta + cap + via + numCiv + btnAggiungi +
      '</div>' +
      '<div class="col-6">' +
      "<h2 style = 'color:white;'>Elimina</h2>" +nomeElim + btnElimina +
      '</div>' +
      '<div class="col-12 text-center">' +
        btnChiudi +
      '</div>' +
    '</div>');

    $("#main-info").hide();
    $("#form-container").show();
}

function caricaFormSlot() {
    $("#title").text("Slot");

    //edit
    let nomeMod = '<input type="text" id="station-name-mod" style = "width: 60%;" placeholder="inserisci il nome della stazione" required>';
    let nuovoNumSlotMod = '<input type="text" id="new-slot-mod" style = "width: 60%;" placeholder="inserisci il nuovo numero di slot" required>';
    let btnModifica = '<button type="button" id="btnModificaSlot" class="btn btn-primary btn-lg m-2" onclick = "modificaSlot()">Modifica</button>';

    let btnChiudi = '<button type="button" class="btn btn-secondary btn-lg m-2" onclick = "chiudi()">Chiudi</button>';

    $("#form-container").html(
        nomeMod + nuovoNumSlotMod + btnModifica +
      '<div class="col-12 text-center">' +
        btnChiudi +
      '</div>'
    );

    $("#main-info").hide();
    $("#form-container").show();
}

function caricaFormBiciclette() {

    $("#title").text("Biciclette");

    //Aggiungi
    //inserire la bici in una stazione
    let nomeStazione = '<input type="text" id="station-name" style = "width: 100%;" placeholder="inserisci il nome della stazione" required>';
    let kmtot = '<input type="text" id="kmTot" style = "width: 100%;" placeholder="inserisci i kilometri totali percorsi" required>';
    let btnAggiungi = '<button type="button" id="btnAggiungiStazione" class="btn btn-primary btn-lg m-2" onclick = "aggiungiBicicletta()">Aggiungi</button>';

    //Elimina
    let id_bici = '<input type="text" id="kmTot" style = "width: 100%;" placeholder="inserisci id bici" required>';
    let btnElimina = '<button type="button" id="btnEliminaStazione" class="btn btn-primary btn-lg m-2" style="background-color: rgb(168, 4, 4); border-color: rgb(138, 2, 2);" onclick = "rimuoviBicicletta()">Elimina</button>';

    let btnChiudi = '<button type="button" class="btn btn-secondary btn-lg m-2" onclick = "chiudi()">Chiudi</button>';

    $("#form-container").html('<div class="row">' +
      '<div class="col-6">' +
        "<h2 style = 'color:white;'>Aggiungi</h2>" + nomeStazione + kmtot + btnAggiungi +
      '</div>' +
      '<div class="col-6">' +
      "<h2 style = 'color:white;'>Elimina</h2>" +id_bici + btnElimina+
      '</div>' +
      '<div class="col-12 text-center">' +
        btnChiudi +
      '</div>' +
    '</div>');

    $("#main-info").hide();
    $("#form-container").show();
}

function chiudi() {
  $("#form-container").empty();
  $("#title").text("Pagina Admin");
  $("#main-info").show();
}