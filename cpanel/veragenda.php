<!DOCTYPE html>
<?php session_start();
$path = dirname(dirname(__FILE__));
include_once $path.'/scripts/dbcfg.php';?>
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
            function addTarea(){
                location.href = "addtarea.php?id=<?php echo $_REQUEST['id']; ?>";
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
                        <li><a href="athletes.php">Atletas</a></li>
                        <li><a href="teams.php">Equipos</a></li>
                    </ul>
                    <h5><b>Información</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="tournaments.php">Administrar torneos</a></li>
                        <li><a href="phases.php">Gestion de Fases</a></li>
                        <li><a href="eventos.php">Gestionar eventos</a></li>
                        <li><a href="places.php">Lugares y edificios</a></li>
                    </ul>
                    <h5><b>Administración del sistema</b></h5>
                    <ul class="nav nav-sidebar">
                        <li><a href="">Agregar usuario</a></li>
                        <li class="active"><a href="agendas.php">Gestionar agendas <span class="sr-only">(current)</a></li>
                        <li><a href="">Gestionar operadores</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Ver agenda</h1>
                    <div class="col-md-12">
                        <?php if(isset($_REQUEST['q']) and $_REQUEST['q']=='addSuccess'){
                                echo "
                                <div class='alert alert-success alert-dismissible fade in role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                <strong>Tarea agregada correctamente&nbsp&nbsp&nbsp</strong><span class='glyphicon glyphicon-ok'></span>
                                </div>";
                        }?>
                        <h3>Viendo agenda para <mark><?php
                        $dbusername = "infoSelect";
                        $dbpass = "infoselectpass";

                        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
                        if ($connection->connect_error) {
                            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
                        } else {
                            $connection->set_charset("utf8");
                            $sql = "SELECT NombrePersona, ApellidoPersona FROM persona WHERE IdPersona=".$_REQUEST['id'];
                            /*$query = $connection->query($sql);*/
                            $connection->set_charset("utf8");
                            $result = mysqli_query($connection, $sql);
                            while($row = $result->fetch_assoc()){
                                echo $_REQUEST['id'] . " - " . $row['NombrePersona'] . " " . $row['ApellidoPersona'];
                            }
                        }
                        ?></mark></h3>
                        <br>
                        <h3 style="display:inline">Tareas&nbsp</h3>
                        <button class="btn btn-success btn-sm" style="display: inline;" onclick="addTarea();"><span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp&nbspAgregar</button>
                        <table class="table table-responsive">
                            <thead>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Lugar</th>
                                <th>Tipo de actividad</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                                <?php
                                    include_once "../scripts/includes/agendas.php";
                                    $agenda = new agendas();
                                    $agenda->poblarPorId($_REQUEST['id']);

                                    for($i=1; $i<=$agenda->largo(); $i++){
                                        echo "<tr>";
                                        echo "<td>" . $agenda->GetValor($i)->GetFecha_Agenda() . "</td>";
                                        echo "<td>" . $agenda->GetValor($i)->GetHora_Agenda() . "</td>";
                                        echo "<td>" . $agenda->GetValor($i)->GetLugar() . "</td>";
                                        echo "<td>" . ucfirst($agenda->GetValor($i)->GetTipo_Agenda()) . "</td>";
                                        echo "<td>" . $agenda->GetValor($i)->GetObservaciones() . "</td>";
                                        echo "<tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <hr><hr>
                        <h3>Eventos</h3>
                        <br>
                        <table class="table table-responsive">
                            <thead>
                                <th>Nombre Evento</th>
                                <th>Disciplina(Categor&iacute;a)[G&eacute;nero]</th>
                                <th>Lugar</th>
                                <th>Fecha y Hora</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                                <?php
                                    include_once "../scripts/includes/eventos.php";
                                    $eventos = new eventos();
                                    $eventos->poblarPorId($_REQUEST['id']);

                                    for($i=1; $i<=$eventos->largo(); $i++){
                                        echo "<tr>";
                                        echo "<td>" . $eventos->GetValor($i)->GetNombre_Evento() . "</td>";
                                        echo "<td>" . $eventos->GetValor($i)->GetCategoria_Evento() . "</td>";
                                        echo "<td>" . ucfirst($eventos->GetValor($i)->GetLugar_Evento()) . "</td>";
                                        echo "<td>" . $eventos->GetValor($i)->GetFechaHora_Evento() . "</td>";
                                        echo "<td>" . $eventos->GetValor($i)->GetEstado_Evento() . "</td>";
                                        echo "<tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
