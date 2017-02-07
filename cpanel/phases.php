<!DOCTYPE html>
<?php
            session_start(); 

          if(isset($_SESSION['username']) and $_SESSION['logged'] == 'true' and ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '3')){
            
                // Lo dejas entrar a la pagina 
            } 
            else 
            {   
                // Usuario que no se ha logueado 
            header('Location: ../index.php');
            exit(); 
            }  
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../icon/favicon.ico">

        <title>Gesti&oacute;n de Fases e Hist&oacute;ricos</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
                <!-- DataTable CSS -->
        <link rel="stylesheet" type="text/css" href="../css/dataTables.css">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>         <script src="../js/controles.js"></script>

        <!-- DataTable Plugins -->
        <script type="text/javascript" charset="utf8" src="../js/dataTables.js"></script>
        <script>
        function ocultar(rol){
            if(rol!="3"){
                document.getElementById("sysmenu").children[0].style.display = "none";
                document.getElementById("sysmenu").children[2].style.display = "none";
            }
        }
        function logout(){
            console.log("borrando session");
            window.location.replace("../scripts/logout2.php");
        }
        </script>

        <!--Script para utilzar DataTable sobre las tablas-->
        <script>
        $(document).ready(function() {
            $('#phases').DataTable( {

                "scrollY":        "300px",
                "scrollCollapse": true,
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    { "bSortable": false },
                    { "bSortable": false }

                ],
                
                "pagingType": "full_numbers",
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }    
                
            } );
            $('#finalphases').DataTable( {

                "scrollY":        "300px",
                "scrollCollapse": true,
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    { "bSortable": false }

                ],
                
                
                "pagingType": "full_numbers",
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }    
                
            } );
        } );

        </script>

        <!-- Confirmar el borrado de una Fase -->
        <script>
            function confirmDeletePhase(id) {
                var x;
                if (confirm("¿Está seguro que desea eliminar esta Fase?") == true) {
                    location.href="../scripts/fillPhases.php?q=deletePhase&id=" + id;
                } else {
                    console.log("Operación cancelada");
                }
            }
        </script>

    </head>
    <?php echo "<body onload='ocultar(".$_SESSION['rol'].")'>"; ?>

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
              <?php echo " <p class='navbar-text'>Bienvenido: &nbsp;".$_SESSION['username']."&nbsp;&nbsp;&nbsp;</p>"; 
                        ?>
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
                        <li><a href="dashboard.php">Inicio</a></li>
                        <li><a href="sports.php">Deportes</a></li>
                        <li><a href="countries.php">Países</a></li>
                        <li><a href="committees.php">Delegaciones</a></li>
                        <li><a href="competitor.php">Participantes</a></li>
                        <li><a href="teams.php">Equipos</a></li>
                    </ul>
                    <h5><b>Información</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="tournaments.php">Administrar torneos</a></li>
                        <li class="active"><a href="#">Gesti&oacute;n de Fases<span class="sr-only">(current)</span></a></li>
                        <li><a href="events.php">Gestionar eventos</a></li>
                        <li><a href="places.php">Lugares y edificios</a></li>
                    </ul>
                    <h5><b>Administración del sistema</b></h5>
                    <ul class="nav nav-sidebar" id="sysmenu">
                        <li><a href="adduser.php">Agregar Admin/Operador</a></li>
                        <li><a href="agendas.php">Gestionar agendas</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Gesti&oacute;n de Fases e Hist&oacute;ricos</h1>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?php
                                    if(isset($_REQUEST['q']) and $_REQUEST['q']=='phaseadded'){
                                     echo "
                                    <div class='alert alert-success alert-dismissible fade in role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                    </button>
                                    <strong>Fase agregada correctamente&nbsp&nbsp&nbsp</strong><span class='glyphicon glyphicon-ok'></span>
                                    </div>";
                                    }
                                    if(isset($_REQUEST['q']) and $_REQUEST['q']=='phaseupdated'){
                                     echo "
                                    <div class='alert alert-success alert-dismissible fade in role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                    </button>
                                    <strong>Fase actualizada correctamente&nbsp&nbsp&nbsp</strong><span class='glyphicon glyphicon-ok'></span>
                                    </div>";
                                    }if(isset($_REQUEST['q']) and $_REQUEST['q']=='phasedeleted'){
                                     echo "
                                    <div class='alert alert-success alert-dismissible fade in role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                    </button>
                                    <strong>Fase eliminada correctamente&nbsp&nbsp&nbsp</strong><span class='glyphicon glyphicon-ok'></span>
                                    </div>";
                                    }
                                ?>
                                <h3 style="display: inline; margin-right: 20px;">Fases</h3>
                                <button class="btn btn-success btn-sm" style="display: inline;" onclick="location.href='addphase.php';"><span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp&nbspAgregar</button>
                                <br><br><br>
                                
                                        <table class='table display' id="phases">
                                            <thead>
                                            <tr>
                                                <th>ID Fase</th>
                                                <th>Nombre</th>
                                                <th>Torneo(A&ntilde;o)</th>
                                                <th>Disciplina[Categoria]</th>
                                                <th>Tipo</th>
                                                <th>Opciones:</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                include_once "../scripts/fillPhases.php";
                                                getPhasesTable();
                                            ?>
                                            </tbody>
                                        </table>
                            </div>
                    </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <br>
                                <h3 style="display: inline; margin-right: 20px;">Fases Finales y SemiFinales, Gestion de Medallas</h3>
                                <br><br><br><br>
                                <div class="table-responsive">
                                    
                                        <table class="table display" id="finalphases">
                                            <thead>
                                                <tr>
                                                <th>ID Fase</th>
                                                <th>Nombre</th>
                                                <th>Torneo(A&ntilde;o)</th>
                                                <th>Disciplina[Categoria]</th>
                                                <th>Opciones:</th>
                                                </tr>
                                            </thead>
                                            <tbody id="country_rows">
                                                <?php
                                                    include_once "../scripts/fillPhases.php";
                                                    getFinalPhasesTable();
                                                ?>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
