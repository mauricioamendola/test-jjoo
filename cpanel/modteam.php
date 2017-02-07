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

        <title>Modificar Participante</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>         <script src="../js/controles.js"></script>
        <script>
                
                function SelectGenero($id) {
                    document.getElementById('Sexo').selectedIndex = '$id';
                }
                    
                function SelectDisciplina($id) {
                document.getElementById('selectedSport').selectedIndex = '$id';
                }
           
                function SelectCategoria($id) {
                document.getElementById('selectedCategory').selectedIndex = '$id';
                }
                
                function SelectTorneo($id) {
                document.getElementById('selectedTourny').selectedIndex = '$id';
                }
             
                function SelectDelegacion($id) {
                document.getElementById('selectedDelegation').selectedIndex = '$id';
                }
              

                    

                function readPreselections(){
                    var select = document.getElementById("preseleccionados");
                    var length = select.options.length;
                    var atletas = new Array();

                    for (i = 0; i<length; i++) {
                        var item = select.item(i);
                        var idatleta = item.value;
                        //console.log(idatleta);
                        atletas[i]=idatleta;
                    }
                    var atletasphp = JSON.stringify(atletas);
                    console.log(atletasphp);

                    var idequipo = document.getElementById("idequipo").value;
                    var nombre = document.getElementById("TeamName").value;
                    var delegacion = document.getElementById("selectedDelegation").value;
                    var categoria = document.getElementById("selectedCategory").value;
                    
                    console.log(idequipo,delegacion,atletasphp,nombre,categoria);
                    //pasara todos los elementos del form

                   window.location.replace("../scripts/FillTeams.php?idequipo=" + idequipo + "&delegation=" + delegacion + "&atletas=" + atletasphp + "&name=" + nombre + "&category=" + categoria+ "&q=modTeam");

                }
                function fillCompetitor1(id, text){
                $("#CompetitorName option").remove();

                var select = document.getElementById("preseleccionados");
                var length = select.options.length;
                for (i = length -1; i >= 0; i--) {
                    console.log("select.remove("+i+")");
                  select.remove(i);
                }


                var xmlhttp = new XMLHttpRequest();
                console.log("fill competitor: ID de la delegacion seleccionada: " + id);
                console.log("fill competitor: Genero del equipo: " + text);
                xmlhttp.open("POST", "../scripts/FillTeams.php?q=fillCompetitor&id=" + id + ",&text=" + text, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                            document.getElementById('selectedCompetitor').innerHTML = xmlhttp.responseText;
        
                        }
                    }

                    xmlhttp.send();
                }

                function fillCompetitor(id, text){
                $("#CompetitorName option").remove();

                var xmlhttp = new XMLHttpRequest();
                console.log("fill competitor: ID de la delegacion seleccionada: " + id);
                console.log("fill competitor: Genero del equipo: " + text);
                xmlhttp.open("POST", "../scripts/FillTeams.php?q=fillCompetitor&id=" + id + ",&text=" + text, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                            document.getElementById('selectedCompetitor').innerHTML = xmlhttp.responseText;
                            borrar();
                        }
                    }

                    xmlhttp.send();
                }

                function borrar(){
                    
                var select = document.getElementById("preseleccionados");
                var length = select.options.length;
                var atletas = new Array();

                    for (i = 0; i<length; i++) {
                        var item = select.item(i);
                        var idatleta = item.value;
                        //console.log(idatleta);
                        atletas[i]=idatleta;
                    }

                var atletasphp = JSON.stringify(atletas);
                console.log("ATLETAS PRESELECCIONADOS:"+atletasphp);

               
                    for (var j=0; j<atletas.length; j++){
                        
                        console.log("select.remove("+atletas[j]+")");
                        $("#selectedCompetitor option[value="+atletas[j]+"]").remove(); 
                    }
                }

                function fillDelegations(id, find) {
                $("#delegationName option").remove();

                var xmlhttp = new XMLHttpRequest();
                console.log("fill delegacion :ID del torneo seleccionado: " + id);
                console.log("fill delegacion :ID de la delegeacion seleccionada: " + find);
                xmlhttp.open("POST", "../scripts/FillTeams.php?q=fillDelegations&id=" + id + "&find=" + find, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('selectedDelegation').innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.send();
                }   


                function fillCategory(id,text,find) {
                    $("#categoryName option").remove();

                    var xmlhttp = new XMLHttpRequest();
                    console.log("fill categoria:ID del deporte seleccionado: " + id);
                    console.log("fill categoria:Genero seleccionado: " + text);
                    console.log("fill categoria:Categoria seleccionada: " + find);
                    xmlhttp.open("POST", "../scripts/FillTeams.php?q=fillCategory&id=" + id + "&genero=" + text + "&find=" + find, true);
                    console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                            document.getElementById('selectedCategory').innerHTML = xmlhttp.responseText;
                        }
                    }
                xmlhttp.send();
                }

                function addTeam(){

                    var t = document.getElementById("selectedCompetitor");
                    var n = document.getElementById("preseleccionados");
                    console.log(t.selectedIndex);
                    console.log(t.options[t.selectedIndex]);

                    var opt = document.createElement('option');
                    opt.value = t.value;
                    opt.innerHTML = t.options[t.selectedIndex].innerHTML;
                    n.appendChild(opt);
                    t.remove(t.selectedIndex);
                }

                function removeTeam(){

                    var t = document.getElementById("selectedCompetitor");
                    var n = document.getElementById("preseleccionados");
                    console.log(n.selectedIndex);
                    console.log(n.options[n.selectedIndex]);

                    var opt = document.createElement('option');
                    opt.value = n.value;
                    opt.innerHTML = n.options[n.selectedIndex].innerHTML;
                    t.appendChild(opt);
                    n.remove(n.selectedIndex);
                }

        </script>
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
                        <li><a href="dashboard.php">Inicio</span></a></li>
                        <li><a href="sports.php">Deportes</a></li>
                        <li><a href="countries.php">Países</a></li>
                        <li><a href="committees.php">Delegaciones</a></li>
                        <li><a href="competitor.php">Participantes</a></li>
                        <li class="active"><a href="teams.php">Equipos<span class="sr-only">(current)</a></li>
                    </ul>
                    <h5><b>Información</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="tournaments.php">Administrar torneos</a></li>
<li><a href="phases.php">Gestion de Fases</a></li>
                        <li><a href="events.php">Gestionar eventos</a></li>
                        <li><a href="places.php">Lugares y edificios</a></li>
                    </ul>
                    <h5><b>Administración del sistema</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Agregar usuario</a></li>
                        <li><a href="agendas.php">Gestionar agendas</a></li>
                        <li><a href="">Gestionar operadores</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                            <?php
                                include_once "../scripts/FillTeams.php";
                                updateTeam($_REQUEST['id'],$_REQUEST['name']);
                            ?> 
                </div>
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </body>
</html>

