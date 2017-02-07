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

        <title>Agregar evento</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- Stylesheet para Font Awesome, se usa solo el glyphicon del trofeo-->
        <link href="../css/font-awesome.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>

        <script src="../js/controles.js"></script>

        <script>
            function fillPhases(){
                var xmlhttp = new XMLHttpRequest();
                var tournyId = document.getElementById("selectedTourny").value;
                xmlhttp.open("POST", "../scripts/fillEvents.php?q=selectTourny&tournyId=" + tournyId , true);
                
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('PhaseList').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.send();
            }
            function fillCategory() {
                $("#selectCategoria option").remove();
                var id = document.getElementById("selectDisciplina").value;
                var xmlhttp = new XMLHttpRequest();
                console.log("ID de la disciplina seleccionada: " + id);
                xmlhttp.open("POST", "../scripts/dataMgmt.php?q=fillCategory&id=" + id, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('selectCategoria').innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.send();
            }

             function Update(){
                    
                    var nombre = document.getElementById("editnombre").value;
                    var fase = document.getElementById("PhaseList").value;
                    var categoria = document.getElementById("selectCategoria").value;
                    var fecha = document.getElementById("inputFecha").value;
                    var hora = document.getElementById("inputHora").value;
                    var lugar = document.getElementById("selectLugar").value;
                    var estado = document.getElementById("selectEstado").value;
                    
                    console.log(nombre, fase, categoria, fecha, hora, lugar, estado);
                    //pasara todos los elementos del form

                   window.location.replace("../scripts/fillEvents.php?nombre=" + nombre + "&categoria=" + categoria + "&fase=" + fase + "&fecha=" + fecha + "&hora=" + hora + "&lugar=" + lugar + "&estado=" + estado + "&q=addEvent");

                }


        </script>

    </head>
    <body onload="fillCategory(); fillPhases()">
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
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <h5><b>Contenido</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="dashboard.php">Inicio</a></li>
                        <li><a href="sports.php">Deportes</a></li>
                        <li><a href="countries.php">Países</a></li>
                        <li><a href="committees.php">Delegaciones</a></li>
                        <li><a href="athletes.php">Atletas</a></li>
                        <li><a href="teams.php">Equipos</a></li>
                    </ul>
                    <h5><b>Información</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="tournaments.php">Administrar torneos</a></li>
                        <li><a href="phases.php">Gestion de Fases</a></li>
                        <li class="active"><a href="events.php">Gestionar eventos <span class="sr-only">(current)</span></a></li>
                        <li><a href="places.php">Lugares y edificios</a></li>
                    </ul>
                    <h5><b>Administración del sistema</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Agregar usuario</a></li>
                        <li><a href="">Gestionar agendas</a></li>
                        <li><a href="">Gestionar operadores</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Agregar evento</h1>
                </div>
                <div class="col-md-10 col-md-offset-2">

                    <div class="col-md-4">
                        <label for="nombre">Nombre del evento:</label>
                        <input type="text" name="nombre" id="editnombre" class="form-control"></input>
                        <br>
                        <label for="torneo">Torneo:</label>
                        <select name="torneo" class="form-control" id="selectedTourny" onchange="fillPhases()">
                             <?php
                                include_once "../scripts/DataMgmt.php";
                                fillTournyDropdown();
                                ?>
                        </select>
                        <br>
                        <label for="PhaseName" class="form-label">Fase a la que pertenecera el evento:</label>
                        <select class="form-control" name="PhaseName" id="PhaseList">      
                        </select>
                        <br>
                        <label for="nombre">Disciplina:</label>
                        <select name="disciplina" class="form-control" id="selectDisciplina" onchange="fillCategory()">
                            <?php
                                    include_once "../scripts/dataMgmt.php";
                                    fillSportsDropdown();
                                ?>
                        </select>
                        <br>
                        <label for="nombre">Categoría:</label>
                        <select name="categoria" class="form-control" id="selectCategoria">
                            
                        </select>
                        <br>
                        <label for="fecha" id="labelFecha">Fecha:</label>
                        <input type="date" name="fecha" id="inputFecha" class="form-control"></input>
                        <br>
                        <label for="hora" id="labelHora">Hora:</label>
                        <input type="time" name="hora" id="inputHora" class="form-control"></input>
                        <br>
                        <label for="nombre">Lugar:</label>
                        <select name="lugar" class="form-control" id="selectLugar">
                            <?php
                                    include_once "../scripts/dataMgmt.php";
                                    fillPlacesdropdown();
                                ?>
                        </select>
                        <br>
                        <label for="nombre">Estado:</label>
                        <br>
                        <select name="estado" id="selectEstado" class="form-control">
                            <option value="activo">Activo</option>
                            <option value="finalizado">Finalizado</option>
                            <option value="programado">Programado</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                        <br><br><button id="update" type="button" class="btn btn-success" onclick="Update()">Agregar evento</button>
                        
                    </div> 
            
                    <br><br>
                </div>
            </div>
        </div>
    </body>
</html>
