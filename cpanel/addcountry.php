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

        <title>Agregar país</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/formValidation.css"/>

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <script type="text/javascript" src="../vendor/jquery/jquery.min.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>         <script src="../js/controles.js"></script>
        <script type="text/javascript" src="../js/formValidation.js"></script>
    </head>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#Agregarpais').formValidation({
                message: 'This value is not valid',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    countryName: {
                        message: 'Nombre de Pais no valido',
                        validators: {
                            notEmpty: {
                                message: 'Debe insertar un nombre al pais'
                            },
                            stringLength: {
                                 min: 1,
                                max: 40,
                                message: 'El nombre del pais debe tener un minimo de 1 letras y un maximo de 40'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9_\.]+$/,
                                message: 'El nombre del pais solo puede consistir en letras, numeros, puntos o parentisis rectos'
                            }
                        }
                    }
                }
            });
        });
    </script>
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
                        <li class="active"><a href="countries.php">Países <span class="sr-only">(current)</a></li>
                        <li><a href="committees.php">Delegaciones</a></li>
                        <li><a href="competitor.php">Participantes</a></li>
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
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Agregar país</h1>
                    <div class="col-md-4">
                        <form id="Agregarpais" action="../scripts/fillCountries.php?q=addCountry" method="post" enctype="multipart/form-data" role="form">
                            <div class="form-group">
                                <label for="countryName" class="form-label">Nombre del país:</label>
                                <input type="text" name="countryName" id="countryName" class="form-control" required oninvalid='this.setCustomValidity("Campo de Nombre Vacío")' oninput='setCustomValidity("")'>
                            <?php 
                            if(isset($_REQUEST['q']) and $_REQUEST['q']=='existepais'){
                            echo "<div class='alert alert-danger alert-dismissible fade in role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                <strong>&nbsp&nbspNombre de país ya existente</strong>
                                </div>";    
                            }
                            ?>
                            </div>
                            <div class="form-group">
                                <label for="region" class="form-label">Región:</label>
                                <?php include_once("../scripts/fillData.php"); fillRegions(); ?>
                            </div>
                            <div class="form-group">
                                <label for="countryIso" class="form-label">Código ISO del país:</label>
                                <input type="text" maxlength="3" name="countryIso" id="countryIso" class="form-control" required oninvalid='this.setCustomValidity("Campo de Iso Vacío")' oninput='setCustomValidity("")'>
                            <?php 
                            if(isset($_REQUEST['q']) and $_REQUEST['q']=='existeiso'){
                            echo "<div class='alert alert-danger alert-dismissible fade in role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                <strong>&nbsp&nbspISO ya existente</strong>
                                </div>";    
                            }
                            ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-md" value="Ingresar País" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </body>
</html>
