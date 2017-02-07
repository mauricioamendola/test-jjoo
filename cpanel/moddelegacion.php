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
        <script src="../js/bootstrap.min.js"></script>         <script src="../js/controles.js"></script>

        <script>
            function updateTable(id){
                $("#committees tbody").remove();

                var xmlhttp = new XMLHttpRequest();
                console.log("ID de torneo seleccionado: " + id);
                xmlhttp.open("POST", "../scripts/dataMgmt.php?q=fillCommittees&id=" + id, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('rows').innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.send();
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
                        <li class="active"><a href="committees.php">Delegaciones <span class="sr-only">(current)</a></li>
                        <li><a href="athletes.php">Atletas</a></li>
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
                    <button type='button' class='btn btn-primary btn-md pull-left' onclick="window.history.back();" value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>
                    <?php echo "<h1 class='page-header'>&nbsp&nbspModificando <kbd>".utf8_encode($_REQUEST['name'])."</kbd></h1>"; ?>
                </div>
                <div class="col-sm-4 col-sm-offset-3 col-md-4 col-md-offset-2 main">
                    <form action="../scripts/dataMgmt.php?q=modCom" method="post" enctype="multipart/form-data" role="form">
                        <div class="form-group">
                            <label for="regionName" class="form-label">Seleccionar torneo:</label>
                            <select name="tournyId" id="tournyYear" style="display: inline; width: 100%;" class="form-control">
                                <?php
                                    include_once "../scripts/dataMgmt.php";
                                    fillTournyDropdown();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comName" class="form-label">Nuevo nombre:</label>
                            <input type="text" class="form-control" name="comName">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
