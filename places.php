<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/header.css" rel="stylesheet">

    <title>OlimpicGames</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://getbootstrap.com.vn/examples/equal-height-columns/equal-height-columns.css" />
    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="icon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="icon/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="icon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="icon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="icon/manifest.json">
    <link rel="mask-icon" href="icon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="icon/mstile-144x144.png">
    <meta name="theme-color" content="#f2b420">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.12.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.color-2.1.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

        <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

    <!--Script para animar los tiles de noticias cuando se hace un mouseover-->
    <script>
              
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
            var iconBase = 'img/mapicon/';
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

            function fillMap(){
                //Creo el objeto de AJAX y llamo al script para cargar los marcadores
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "scripts/places.php?q=fillMarkers");

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        //Creo un array para los marcadores, y le pongo los marcadores que traigo de PHP
                        var lista = new Array();
                        console.log(xmlhttp.responseText);
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

            function fillMap2(filtro){
                //Creo el objeto de AJAX y llamo al script para cargar los marcadores
                clearMarkers();
                var xmlhttp = new XMLHttpRequest();
                console.log("El filtro seleccionado es: " + filtro);

                xmlhttp.open("POST", "scripts/places.php?q=fillMarkersFiltro&tipo=" + filtro, true);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        //Creo un array para los marcadores, y le pongo los marcadores que traigo de PHP
                        var lista = new Array();
                        console.log(xmlhttp.responseText);
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

            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }

            // Muestra los marcadores que hay en el array.
            function showMarkers() {
                setMapOnAll(map);
            }

            function addMarker(location) {

                //if (typeof location.type !== 'undefined') {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: icons[location.type].icon
                });
                    

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

        function clearMarkers() {
             setMapOnAll(null);
        }

         $('.carousel').carousel({
        interval: 500 //changes the speed
        });
        </script>

        <style>
           /*html, body {
            height: 100%;
            margin: 0;
            padding: 0;
          }*/
          #map {
            margin-top: 20px;
            height: 400px;
            width: 100%;
          }

          #legend {
              font-family: Arial, sans-serif;
              background: #fff;
              padding: 10px;
              margin: 10px;
              border: 1px solid #CCC;
              border-radius: 10px;
          }

          #legend h3 {
              margin-top: 0;
          }

          #legend img {
              vertical-align: middle;
              width: 20px;
              height: 20px;
          }
        </style>
</head>

<body  onload="fillMap()">

    <nav class="navbar navbar-inverse sidebar" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   <li><span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span><a href="index.php">Home</a></li>
                    <li ><a href="athlete.php">Deportistas<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                    <li ><a href="disciplinas.php">Deportes<span style="font-size:16px;" class="pull-right hidden-xs showopacit"></span></a></li>
                    <li ><a href="historicos_delegaciones.php">Historicos por Torneo<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                    <li ><a href="historicos.php">Historicos por Deportes<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                    <li class="active"><a href="places.php">Servicios<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>

                </ul>
            </div>
        </div>
    </nav>

    <header id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                <a href="places.php">
                    <div class="fill" style="background-image:url('img/slide1.jpg');"></div>
                    <div class="carousel-caption">
                        <h2>Servicios</h2>
                    </div>
                </a>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('img/slide2.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Historia de los JJOO</h2>
                </div>
            </div>
             <div class="item">
                <a href="historicos.php">
                    <div class="fill" style="background-image:url('img/slide3.jpg');"></div>
                    <div class="carousel-caption">
                        <h2>Medalleros</h2>
                    </div>
                </a>
            </div>
        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>
    
    <div>
        <br>
    </div>  
    
    <div class="todo">
        <div class="form-group">
            <label for="Servicio" class="form-label">Servicio:</label>
                <select name="Servicio" id="SelectedServicio" class="form-control" onchange="fillMap2(document.getElementById('SelectedServicio').value)">
                    <option value="todos"> Todos </option>
                    <option value="estadio"> Estadios </option>
                    <option value="restaurant"> Restaurantes </option>
                    <option value="hotel"> Hotel </option>
                    <option value="seguridad"> Seguridad </option>
                    <option value="espectaculos"> Espectaculos </option>
                    <option value="shopping"> Shopping </option>
                    <option value="atencion_medica"> Atencion Medica </option>
                    <option value="banco"> Banco </option>
                </select>
        </div>
        
        <div class="col-sm-12">
            <div class="col-md-12">
                <div id="result"></div>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfUSd5gVIvIJcaHRt0lbj-t2sxFfTd5Ww&callback=initMap"
                                    async defer>
                </script>
                <div id="map"></div>
                <div id="legend"><h3>Leyenda</h3></div>
            </div>
        </div>
          
    </div>
        
            
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p style="text-align: center; vertical-align: center;">Copyright &copy; Todos los derechos reservados - DevOps Crew Inc.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
