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

        <title>Gestionar Resultados</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!-- Timepicker core CSS
        <link href="../css/jquery-ui-timepicker-addon.css" rel="stylesheet"> -->

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- Stylesheet para Font Awesome, se usa solo el glyphicon del trofeo-->
        <link href="../css/font-awesome.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script>
        <!-- jQuery requerido para timepicker 
        <script src="../js/jquery-ui-timepicker-addon.js"></script>-->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>

        <script>

        function Fillpartialsresults(){

            var idevento = document.getElementById("idevento").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "../scripts/fillEvents.php?q=fillpartialResults&evento=" + idevento, true);
            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

            xmlhttp.onreadystatechange = function() {

                if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                    document.getElementById('resultlist').innerHTML = xmlhttp.responseText;
                }
            }

            xmlhttp.send();
        }

        function Fillplayersonfinal(){
            var xmlhttp = new XMLHttpRequest();
            var idevento = document.getElementById("idevento").value;
            var tipo = document.getElementById("RFTipo").value;
            console.log("evento: " + idevento);
            console.log("tipo: " + tipo);

            xmlhttp.open("POST", "../scripts/fillEvents.php?q=fillplayers&evento=" + idevento + "&tipo=" + tipo, true);
            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

            xmlhttp.onreadystatechange = function() {

                if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                    console.log("Estado del XmlHttpRequest: " + xmlhttp.responseText);
                    document.getElementById('dynamiccompetitors').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.send();
        }

        function Fillfinalresult(){
            var idevento = document.getElementById("idevento").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "../scripts/fillEvents.php?q=fillfinalResults&evento=" + idevento, true);
            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

            xmlhttp.onreadystatechange = function() {

                if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                    document.getElementById('finalresult').innerHTML = xmlhttp.responseText;
                }
            }

            xmlhttp.send();
        }

        function ImpactResults(){
                var evento = document.getElementById("idevento").value;
                var x = document.getElementById("resultados");
                var txt = "";
                var i = 0;
                for (i = 0; i< x.length; i++) {
                    if ( x.elements[i].getAttribute('name') == 'nombre[]'){
                        txt = txt +"!"+ x.elements[i].value + "/";
                        console.log('elemento:'+txt);
                    }else{
                        txt = txt + x.elements[i].value + "/";
                        console.log('elemento:'+txt);
                    }
                }
                window.location.replace("../scripts/fillEvents.php?parametros="+txt+"&q=Manageresult&evento="+evento);
        }

        function lastParagraphBeGone() { 
                var paragraphs = document.getElementById("resultlist").getElementsByTagName("div");
                var lastParagraph = paragraphs[paragraphs.length-4];
                lastParagraph.parentNode.removeChild(lastParagraph);
                }
                
        function fillResults(){

            var xmlhttp = new XMLHttpRequest();
            var idevento = document.getElementById("idevento").value;
            var tipo = document.getElementById("RTipo").value;
            var div = document.createElement("div");
            console.log("valor de idevento: " + idevento);
            console.log("valor de tipo: " + tipo);
            xmlhttp.open("POST", "../scripts/fillEvents.php?q=fillResults&evento=" + idevento + "&tipo=" + tipo, true);
            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

            xmlhttp.onreadystatechange = function() {
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    console.log("Estado del XmlHttpRequest prueba: " + xmlhttp.readyState);
                    div.innerHTML = xmlhttp.responseText;
                    document.getElementById('resultlist').appendChild(div);
                }
            }
            xmlhttp.send();
        }

        function addInput(divName){
            
        
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Entry " + (counter + 1) + " <br><input type='text' name='myInputs[]'>";
          document.getElementById(divName).appendChild(newdiv);
          
        }

        </script>

    </head>
    <body onload='Fillfinalresult(); Fillpartialsresults();'>
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
                    <button type='button' class='btn btn-primary btn-md pull-left' onclick='window.history.back();' value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>
                    <h1 class='page-header'>&nbsp&nbsp&nbspGestion de Resultados</h1>
                    <?php
                        echo "<h2 class='page-header'>&nbsp&nbsp&nbspEvento Nº<kbd>".$_REQUEST['id']."</kbd>, <kbd>".$_REQUEST['name']." </kbd></h2>";
                    ?>
                    <div class='form-inline col-md-12' id='Final'>
                        <div class='col-md-3'>
                            <?php
                            echo "<input type='hidden' name='idevento' id='idevento' value='".$_REQUEST['id']."'>" 
                            ?>
                            <label for='RTipo' class="form-label">Tipo de Resultado:</label>
                            <select class="form-control" name='RTipo' id='RTipo' class='form-control'>";
                                <option value='puntos' selected>&nbsp;Puntos&nbsp;</option>
                                <option value='tiempo'>&nbsp;Tiempo&nbsp;</option>
                                <option value='distancia'>&nbsp;Distancia&nbsp;</option>
                            </select>
                        </div>
                        <div class='col-md-3'>
                            <button type='button' class='btn btn-success btn-md' value='Gestion Equipos' name='submit' onclick='fillResults()'><span style="font-size: 14px;"class="glyphicon glyphicon-plus"></span>&nbsp&nbspAgregar Resultados Parciales</button>
                        </div>
                        <div class='col-md-3'>
                        <button type='button' class='btn btn-danger btn-md' value='Gestion Equipos' name='removebutton' onclick='lastParagraphBeGone()'><span style="font-size: 14px;"class="glyphicon glyphicon-minus"></span>&nbsp&nbspEliminar &Uacute;ltimo Resultado Parcial</button>
                        </div>
                        <div class='col-md-3'>
                        <button type='button' class='btn btn-warning btn-md' value='Gestion Equipos' name='submit' onclick='ImpactResults()'><span style="font-size: 14px;"class="glyphicon glyphicon-ok"></span>&nbsp&nbspFinalizar Gestion de Resultados</button>
                        </div>
                    </div>
                <br>   
                <form action='' method='post' id='resultados' enctype='multipart/form-data' role='form'>
                    <div id='finalresult'>
                    </div>
                    <hr><hr><br><br>
                    <div id='resultlist'>
                    </div>
                    <hr><hr>
                    <br><br>
                </form>     
                </div>
            </div>
        </div>
    </body>
</html>
