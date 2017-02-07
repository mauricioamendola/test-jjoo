<!DOCTYPE html>
<?php session_start();
$path = dirname(dirname(__FILE__));
include_once 'scripts/dbcfg.php';?>
<html lang="es">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Las etiquetas de arriba DEBEN ir primero. Cualquier otro contenido del head debe ir DESPU?S de estas etiquetas-->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/header.css" rel="stylesheet">
        <title>AGENDA</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.12.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <!--bootstrap-select para darle estilos a los dropdown-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

        <!-- Iconos. Hay varios, que sirven para que cada plataforma elija la que m?s le guste -->
        <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="icon/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="icon/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="icon/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="icon/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="icon/manifest.json">
        <link rel="mask-icon" href="icon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="icon/mstile-144x144.png">
        <meta name="theme-color" content="#f2b420">
       	<script>
      	</script>
    </head>
    <body>
        <div class="cabecera">
            <div class="nav-container">
                <div class="navbar navbar-default">
       				<div class="navbar-header navbar-left container-fluid">
                    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tohide" aria-expanded="false" aria-controls="navbar">
                        	<span class="sr-only">Toggle navigation</span>
                        	<span class="icon-bar"></span>
                        	<span class="icon-bar"></span>
                        	<span class="icon-bar"></span>
                    	</button>
						<a href="index.html" class="navbar-brand">ElsupernombredelaSuper</a>
                    </div>

                    <ul class="nav navbar-nav navbar-left">
                    	<li class="dropdown">
                        	<a class="dropdown-toggle hidden-xs" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><img src="img/big_button.svg" width="45em" height="45em" onerror="if (this.src != 'img/big_button.png') this.src = 'img/big_button.png';"><span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu">
                            	<li><a href="index.php" id="dropdown-news">Noticias</a></li>
                                <li><a href="#" id="dropdown-info">Información</a></li>
                                <li><a href="disciplinas.php" id="dropdown-deportes">Deportes</a></li>
                                <li><a href="Paises.php" id="dropdown-paises">Países</a></li>
                                <li><a href="athlete.php" id="dropdown-atletas">Atletas</a></li>
                                <li><a href="#" id="dropdown-entradas">Entradas</a></li>
                                <li><a href="#" id="dropdown-viajar">Viajar</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div id="tohide" class="navbar-collapse collapse">
                    	<div class="container-fluid">
                    		<div class="navbar-right">
                            	<ul class="login-links" style="margin-right:30px;">
                                	<?php
                                		if (isset($_COOKIE["username"])) {
                                        	echo "<li class='navbar-text'><a href='account.php'>".$_COOKIE['username']."</a></li>";
                                            echo "<li class='navbar-text'><a href='favs.php'>Favoritos</a></li>";
                                            echo "<li class='navbar-text'><a href='logout.php'>Salir</a></li>";
                                        } else {
                                        	echo "<li class='navbar-text'><a href='login.php'>Iniciar sesi&oacuten</a></li>";
                                            echo "<li class='navbar-text'><a href='imagenes.php'>Registro</a></li>";
										}
                                    ?>
                                </ul>
                            </div>
                           	<form class="navbar-form navbar-right" role="search">
	                            <div class="input-group">
	                            	<input type="text" class="form-control" placeholder="Buscar...">
	                                <span class="input-group-btn">
	                                	<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
	                                </span>
	                            </div>
						    </form>
                        </div>
                   	</div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Ver agenda</h1>
            <div class="col-md-12">
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
                    <table class="table table-responsive">
                    	<thead>
                        	<th>Fecha y hora</th>
                            <th>Tipo de actividad</th>
                            <th>Observaciones</th>
                        </thead>
                    	<tbody>
                        	<?php
                            	include_once "scripts/includes/agendas.php";
                                $agenda = new agendas();
                                $agenda->poblarPorId($_REQUEST['id']);

                                for($i=1; $i<=$agenda->largo(); $i++){
                                	echo "<tr>";
                                    	echo "<td>" . $agenda->GetValor($i)->GetFechaHora_Agenda() . "</td>";
                                    	echo "<td>" . ucfirst($agenda->GetValor($i)->GetTipo_Agenda()) . "</td>";
                                    	echo "<td>" . $agenda->GetValor($i)->GetObservaciones() . "</td>";
                                    echo "<tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        <h3>Eventos</h3>
                        <table class="table table-responsive">
                            <thead>
                                <th>Fecha y hora</th>
                                <th>Tipo de actividad</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                                <?php
                                    include_once "scripts/includes/eventos.php";
                                    $eventos = new eventos();
                                    $eventos->poblarPorId($_REQUEST['id']);

                                    for($i=1; $i<=$eventos->largo(); $i++){

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
