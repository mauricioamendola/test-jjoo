//Variables que necesita la API de Google Maps
var map;
var markers = [];
var userMarkers = [];

var styles = [
  {
    "featureType": "poi",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "transit",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  }
]




//El array icons tiene la ubicación de los íconos según el tipo de lugar.
var iconBase = '../img/mapicon/';
var icons = {
    hotel: {
        name: "Hotel",
        icon: iconBase + 'hotel.png'
    },
    restaurant: {
        name: "Restaurante",
        icon: iconBase + 'restaurant.png'
    },
    seguridad: {
        name: "Seguridad",
        icon: iconBase + 'seguridad.png'
    },
    espectaculos: {
        name: "Espectáculos",
        icon: iconBase + 'espectaculos.png'
    },
    banco: {
        name: "Servicios Financieros",
        icon: iconBase + 'banco.png'
    },
    shopping: {
        name: "Compras",
        icon: iconBase + 'shopping.png'
    },
    atencion_medica: {
        name: "Atención médica",
        icon: iconBase + 'atencion_medica.png'
    },
    estadio: {
        name: "Estadio",
        icon: iconBase + 'estadio.png'
    }
};

function confirmDelete(id){
    if (confirm("¿Está seguro que desea eliminar el lugar seleccionado?") == true) {
        location.href="../scripts/dataMgmt.php?q=deletePlace&id=" + id;
    } else {
        console.log("Operación cancelada");
    }
}

function fillMap(){
    //Creo el objeto de AJAX y llamo al script para cargar los marcadores
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../scripts/places.php?q=fillMarkers");

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //Creo un array para los marcadores, y le pongo los marcadores que traigo de PHP
            var lista = new Array();
            lista = JSON.parse(xmlhttp.responseText); //Necesito hacer un parse de JSON para que JavaScript pueda leer el contenido del array de PHP

            //Muestro esto en la consola para debugging
            console.log("Cantidad de lugares cargados: " + lista.length);
            console.log(lista);

            for (i=0; i<lista.length; i++){
                
                var location = {
                    lat: parseFloat(lista[i].Latitud),
                    lng: parseFloat(lista[i].Longitud),
                    type: String(lista[i].TipoServicio),
                    name: String(lista[i].Nombre),
                    address: String(lista[i].Direccion),
                    web: String(lista[i].Web)
                }; //Coordenadas para gregar un marcador, por cada entrade del array
                addMarker(location);
            }
        }
    }

    xmlhttp.send();
}

function initMap() {
    //Inicializo el mapa en Río
    var coordenadas = {lat: -22.9764528, lng: -43.4156944};

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: coordenadas
    });

    var legend = document.getElementById('legend');
    for (var key in icons) {
        var type = icons[key];
        var name = type.name;
        var icon = type.icon;
        var div = document.createElement('div');
        div.innerHTML = '<img src="' + icon + '"> ' + name;
        legend.appendChild(div);
    }

    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    map.setOptions({styles: styles});
}

// Adds a marker to the map and push to the array.
function addMarker(location) {

    //if (typeof location.type !== 'undefined') {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: icons[location.type].icon
        });
    /*} else {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: icons[estadio].icon
        });
    }*/

    marker.setAnimation(google.maps.Animation.DROP);
    markers.push(marker);

    var contentString = '<div id="content" width="50px">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h2 id="firstHeading" class="firstHeading">' + location.name + '</h2>'+
        '<div id="bodyContent">'+
        '<p><b>Dirección: </b>'+ location.address + '</p>'+
        '<p><b>Sitio Web: </b> <a href="http://' + location.web + '">'+
        'http://' + location.web + '</a> </p>'+
        '</div>'+
        '</div>';

    var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 300
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

//Remueve los marcadores del mapa, pero se mantienen en el array.
function clearMarkers() {
  setMapOnAll(null);
}

// Muestra los marcadores que hay en el array.
function showMarkers() {
  setMapOnAll(map);
}

// Borra los marcadores del mapa y del array
function deleteMarkers() {
  clearMarkers();
  markers = [];
}
