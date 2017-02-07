<!DOCTYPE html>
<?php
    session_start();
    if(isset($_REQUEST['sname']) and isset($_REQUEST['sid'])){
        $sname = $_REQUEST['sname'];
        $sid = $_REQUEST['sid'];
    }
?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../icon/favicon.ico">

        <title>Categorías para <?php echo $sname;?></title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/jquery.dataTables.css" rel="stylesheet">
        

        <!-- Stylesheet for the dashboard -->
        <link href="../css/dashboard.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
                <!-- DataTable CSS -->
        <link rel="stylesheet" type="text/css" href="../css/dataTables.css">

        
        <!-- Include all compiled plugins (below), or include<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.12.3.js"></script> 
        <script src="../js/bootstrap.min.js"></script>         <script src="../js/controles.js"></script>
        <!-- DataTable Plugins -->
        <script type="text/javascript" charset="utf8" src="../js/dataTables.js"></script>

         <!--Script para utilzar DataTable sobre las tablas-->
        <script>
        $(document).ready(function() {
            $('#categories').DataTable( {

                "scrollY":        "400px",
                "scrollCollapse": true,
                "aoColumns": [
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
        } );

        </script>
        <!-- Buscar categorías por el nombre -->
        <script>
            function searchSports(text, id){
                $("#category tbody tr").remove();

                var xmlhttp = new XMLHttpRequest();
                console.log("Texto a buscar: " + text);
                xmlhttp.open("POST", "../scripts/fillSports.php?q=searchcat&s=" + text + "&id=" + id, true);
                console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                        document.getElementById('category-rows').innerHTML = xmlhttp.responseText;
                        document.getElementById('scroll-anchor').scrollIntoView();
                    }
                }
                xmlhttp.send();
            }

            function confirmDeleteCategory(id){
                if (confirm("¿Está seguro que desea eliminar la categoría?") == true) {
                    location.href="../scripts/fillSports.php?q=deleteCategory&id=" + id;
                } else {
                    console.log("Operación cancelada");
                }
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
                        <li class="active"><a href="sports.php">Deportes<span class="sr-only">(current)</span></a></li>
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
                    <?php
                        echo "<h1 class='page-header' style='display: inline;'>&nbsp&nbspViendo categorías para ".utf8_encode($_REQUEST['sname'])."</h1><button type='button' class='btn btn-primary btn-md pull-left' onclick=goBack() value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>";
                    ?>
                    <br><br><br>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?php
                                    if(isset($_REQUEST['q']) and $_REQUEST['q']=='add'){
                                        echo "
                                                <div class='row'>
                                                        <div class='alert alert-success' role='alert'>Categoría agregada correctamente&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-ok'></span></div>
                                                </div>";
                                    }
                                    if(isset($_REQUEST['q']) and $_REQUEST['q']=='update'){
                                        echo "
                                                <div class='row'>
                                                        <div class='alert alert-success' role='alert'>Categoría actualizada correctamente&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-ok'></span></div>
                                                </div>";
                                    }
                                ?>
                                <h3 style="display: inline; margin-right: 20px;">Categorías</h3>
                                <?php
                                    $ename = urlencode($sname);
                                    $uri = "addcategory.php?ename=".$ename."&sid=".$sid."";
                                ?>
                                <button class="btn btn-success btn-sm" style="display: inline;" onclick="location.href='<?php echo $uri; ?>'"><span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp&nbspAgregar</button>
                                <br><br>
                                <form>
                                    <label for="searchBox" class="form-label" id="search-label">Buscar:</label>
                                    <input type="text" id="searchBox" class="form-control" style="width: 30%; display:inline;">
                                    <input type="hidden" id="sid" value='<?php echo "$sid"; ?>'>
                                    <button type="button" onclick="searchSports(document.getElementById('searchBox').value, document.getElementById('sid').value)" style="display:inline;" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                                </form>
                                <br><br>
                                <div class="table-responsive">
                                    <table class='display compact' id='categories'>
                                        <thead>
                                        <tr>
                                            <th>ID Categoria</th>
                                            <th>Categoria</th>
                                            <th>Genero</th>
                                            <th>Opciones:</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="category-rows">
                                            <?php
                                                include_once "../scripts/fillSports.php";
                                                getCategoryTable($sid);
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
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/jquery.dataTables.js"></script>
</html>
