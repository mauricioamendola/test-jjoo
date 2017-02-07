<!DOCTYPE html>
<?php session_start(); ?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../icon/favicon.ico">

        <title>Panel de administración de la aplicación</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.js"></script>

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
    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Rio 2016</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        

                        
                        <li><a href="#" onclick="logout()">Cerrar sesión</a></li>
                    </ul>

                        
                    
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <h5><b>Contenido</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="#">Inicio</span></a></li>
                        <li><a href="sports.php">Deportes</a></li>
                        <li><a href="countries.php">Países</a></li>
                        <li><a href="committees.php">Delegaciones</a></li>
                        <li><a href="competitor.php">Participantes</a></li>
                        <li><a href="teams.php">Equipos</a></li>
                    </ul>
                    <h5><b>Información</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="tournaments.php">Administrar torneos</a></li>
<li><a href="phases.php">Gestion de Fases</a></li>
                        <li><a href="events.php">Gestionar eventos</a></li>
                        <li class="active"><a href="">Lugares y edificios <span class="sr-only">(current)</a></li>
                    </ul>
                    <h5><b>Administración del sistema</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Agregar usuario</a></li>
                        <li><a href="agendas.php">Gestionar agendas</a></li>
                        <li><a href="">Gestionar operadores</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-md-offset-2 main">
                    <button type='button' class='btn btn-primary btn-md pull-left' onclick="window.history.back();" value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>
                    <h1 class="page-header" style="display:inline; margin-right: 20px;">&nbsp&nbspAgregar lugar</h1>
                    <br><br>
                    <!--<div class="col-md-4">-->
                        <form action="../scripts/dataMgmt.php?q=addPlace" method="post" enctype="multipart/form-data" role="form">
                            <div class="form-group">
                                <label for="name" class="form-label">Nombre del lugar:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address" class="form-label">Dirección:</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="web" class="form-label">Sitio web:</label>
                                <input type="text" name="web" id="web" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lat" class="form-label">Latitud:</label>
                                <input type="text" name="lat" id="lat" class="form-control" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="lon" class="form-label">Longitud:</label>
                                <input type="text" name="lon" id="lon" class="form-control" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="type" class="form-label">Tipo:</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="atencion_medica">Atención médica</option>
                                    <option value="restaurant">Restaurant</option>
                                    <option value="banco">Servicios financieros</option>
                                    <option value="hotel">Hotel</option>
                                    <option value="espectaculos">Espectáculos</option>
                                    <option value="shopping">Compras</option>
                                    <option value="estadio">Recinto deportivo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Ingresar país" name="submit" class="btn btn-success">
                            </div>
                        </form>
                    <!--</div>-->
                </div>
                <div class="col-md-6">
                    <!--<div class="col-md-10 col-sm-offset-2">-->
                        <div id="result"></div>
                        <p class="page-header"><i>Haga click en el mapa para seleccionar la ubicación</i></p>
                            <div id="map"></div>
                            <script>
                                var map;
                                var markers = [];

                                function initMap() {
                                    var coordenadas = {lat: -22.9764528, lng: -43.4156944};

                                    map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 12,
                                        center: coordenadas
                                    });

                                    // This event listener will call addMarker() when the map is clicked.
                                    map.addListener('click', function(event) {
                                        clearMarkers();
                                        deleteMarkers();
                                        addMarker(event.latLng);
                                        document.getElementById("lat").value = event.latLng.lat();
                                        document.getElementById("lon").value = event.latLng.lng();
                                    });

                                    // Adds a marker at the center of the map.
                                    //addMarker(coordenadas);
                                }

                                // Adds a marker to the map and push to the array.
                                function addMarker(location) {
                                    clearMarkers();

                                    var marker = new google.maps.Marker({
                                        position: location,
                                        map: map
                                    });

                                    marker.setAnimation(google.maps.Animation.DROP);
                                    markers.push(marker);
                                    map.panTo(marker.getPosition());
                                }

                                // Sets the map on all markers in the array.
                                function setMapOnAll(map) {
                                  for (var i = 0; i < markers.length; i++) {
                                    markers[i].setMap(map);
                                  }
                                }

                                // Removes the markers from the map, but keeps them in the array.
                                function clearMarkers() {
                                  setMapOnAll(null);
                                }

                                // Shows any markers currently in the array.
                                function showMarkers() {
                                  setMapOnAll(map);
                                }

                                // Deletes all markers in the array by removing references to them.
                                function deleteMarkers() {
                                  clearMarkers();
                                  markers = [];
                                }
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfUSd5gVIvIJcaHRt0lbj-t2sxFfTd5Ww&callback=initMap"
                                async defer>
                            </script>

                    <!--</div>-->
                </div>
            </div>
        </div>
    </body>
</html>
