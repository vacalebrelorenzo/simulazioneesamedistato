//gestione mapp
$(document).ready(function(){
    getStationLocation();
});

var map;

//mappa iniziale
document.addEventListener('DOMContentLoaded', (event) => {

    map = L.map('map').setView([45.4654219, 9.1859243], 13);
 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
});

//aggiunta di tutti i marker
function addMarker(data)
{
    for(let i = 0; i < data["vettore"].length; i++)
    {
        let marker = L.marker([data["vettore"][i]["latitudine"], data["vettore"][i]["longitudine"]]).addTo(map);
        marker.bindPopup(data["vettore"][i]["nome"]);
    }
}

