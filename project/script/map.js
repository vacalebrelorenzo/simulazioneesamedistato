var map;

document.addEventListener('DOMContentLoaded', (event) => {

    map = L.map('map').setView([45.46756502411385, 9.185421017988913], 13);
 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
});

function addMarker(data)
{
    let arr = JSON.parse(data);
    console.log(arr);

    for(let i = 0; i < arr["vettore"].length; i++)
    {
        let marker = L.marker([arr["vettore"][i]["latitudine"], arr["vettore"][i]["longitudine"]]).addTo(map);
        marker.bindPopup("Stazione " + (i+1));
    }
}

