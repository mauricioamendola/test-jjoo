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

        <title>Agregar Participante</title>

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
            function Completa(){
                for (i = 1; i < 500; i++){ 
                    $('#alturapicker').append($('<option />').val(i).html(i));
                }
                for (i = 1; i < 500; i++){
                    $('#pesopicker').append($('<option />').val(i).html(i));
                }
            }
            function CompetitorType() 
            {
                    $("#tipo").change(
                    function CompetitorType() 
                    {
                        if ($("#TipoPersonal").is(":selected")) {
                            $("#Personal").show();
                            $("#Deportista").hide();
                        } else {
                            $("#Personal").hide();
                            $("#Deportista").show();
                        }
                    }).trigger('change');
            }
        </script>
    </head>
    <body onload="Completa(); CompetitorType();">

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
                        <ul class="nav nav-sidebar">
                        <li><a href="dashboard.php">Inicio</span></a></li>
                        <li><a href="sports.php">Deportes</a></li>
                        <li><a href="countries.php">Países</a></li>
                        <li><a href="committees.php">Delegaciones</a></li>
                        <li class="active"><a href="competitor.php">Participantes<span class="sr-only">(current)</a></li>
                        <li><a href="teams.php">Equipos</a></li>
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
                    <button type='button' class='btn btn-primary btn-md pull-left' onclick="window.history.back();" value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>
                    <h1 class="page-header">&nbsp&nbsp&nbspAgregar Participante</h1>
                    <form action="../scripts/fillCompetitor.php?q=addcompetitor" method="post" enctype="multipart/form-data" role="form">
                       <div class="form-group">
                            <label for="CompetitorName" class="form-label">Nombre del Participante:</label>
                            <input type='text' name='CompetitorName' id='CompetitorName' class='form-control'  required oninvalid='this.setCustomValidity("Campo de Nombre Vacío")' oninput='setCustomValidity("")'>
                        </div>
                        <div class="form-group">
                            <label for="CompetitorSurname" class="form-label">Apellido del Participante:</label>
                            <input type='text' name='CompetitorSurname' id='CompetitorSurname' class='form-control' required oninvalid='this.setCustomValidity("Campo de Apellido Vacío")' oninput='setCustomValidity("")'>
                        </div>
                        <div class="form-group">
                            <label for="sexo" class="form-label">Sexo</label>
                                <select class='form-control' name='sexo' id='sexo'>
                                    <option value="mujer">Mujer</option>
                                    <option value="hombre">Hombre</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label for="Pais" class="form-label">Pa&iacute;s</label>
                                <select class='form-control' name='pais' id='pais' onchange='fillCountries(this.value)'>
                                <?php include_once("../scripts/fillCompetitor.php"); CompletaPaises(''); ?>
                        </div>
                        <div class="form-group">
                                <label for="tipo" class="form-label">Tipo de Participante</label>
                                <select class="form-control" name="tipo" id="tipo">
                                    <option id="TipoDeportista">Deportista</option>
                                    <option id="TipoPersonal">Personal</option>
                                </select>  
                        </div>
                        <div id="Personal" class="form-group">
                            <label for="Pais" class="form-label">Tipo de Personal</label>
                                <select class='form-control' name='personal' id='personal'>
                                    <option value="medico">M&eacute;dico</option>
                                    <option value="cocinero">Cocinero</option>
                                    <option value="tecnico">T&eacute;cnico</option>
                                    <option value="entrenador">Entrenador</option>
                                    <option value="otro">Otro</option>
                                </select>
                        </div>  
                        <div id="Deportista" class="form-group">
                            <label for="Deportista" class="form-label">Altura:</label>
                            <select name="alturapicker" id="alturapicker"></select>
                            <label for="Deportista" class="form-label">cms.</label>
                        </br></br>
                            <label for="Deportista" class="form-label">Peso:</label>
                            <select name="pesopicker" id="pesopicker"></select>
                            <label for="Deportista" class="form-label">kgs.</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success btn-md" value="Añadir Participante" name="submit">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </body>
</html>

