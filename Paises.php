<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Las etiquetas de arriba DEBEN ir primero. Cualquier otro contenido del head debe ir DESPUÉS de estas etiquetas-->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/header.css" rel="stylesheet">
        <title>Paises</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <!--bootstrap-select para darle estilos a los dropdown-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

        <!-- Iconos. Hay varios, que sirven para que cada plataforma elija la que más le guste -->
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
        <!-- es para los combo -->
		<script type="text/javascript" src="select_Pais.js"></script>
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
                                                echo "<li class='navbar-text'><a href='login.php'>Iniciar sesión</a></li>";
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

        <div class="rss-container">
            <div class="container-fluid">
                <h1 class="page-title">Disciplinas</h1>
                <div class="row">
                    <div class="col-md-4 col-custom-list">
                        <?php
                            include 'select_Pais.php';
                            generaPaises(); 
                        ?>
                    </div>
					
					<div class="col-md-4 col-custom-list">

						<select name="Delegacion" id="Delegacion" class="form-control" size="10" multiple>
							<option value="0">Selecciona opci&oacute;n...</option>
						</select>
					</div>

                </div>
            </div>
        </div>			
		
	</body>
</html>