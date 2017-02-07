<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Las etiquetas de arriba DEBEN ir primero. Cualquier otro contenido del head debe ir DESPUÉS de estas etiquetas-->
        <link href="css/custom.css" rel="stylesheet">
        <link href="css/header.css" rel="stylesheet">
        <title>Nombre de la aplicación</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="http://getbootstrap.com.vn/examples/equal-height-columns/equal-height-columns.css" />-->

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

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <!--Script para animar los tiles de noticias cuando se hace un mouseover-->
        <!--<script>
            $("div.col-custom").mouseover(function(){
                $("div.col-custom").animate({
                    height: 110%;
                    width: 110%;
                });
            });
        </script>-->
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
                                    <li><a href="index.php" id="dropdown-news" target="main_iframe">Noticias</a></li>
                                    <li><a href="#" id="dropdown-info" target="main_iframe">Información</a></li>
                                    <li><a href="sports.php" id="dropdown-deportes" target="main_iframe">Deportes</a></li>
                                    <li><a href="#" id="dropdown-paises" target="main_iframe">Países</a></li>
                                    <li><a href="athlete.php" id="dropdown-atletas" target="main_iframe">Atletas</a></li>
                                    <li><a href="#" id="dropdown-entradas" target="main_iframe">Entradas</a></li>
                                    <li><a href="#" id="dropdown-viajar" target="main_iframe">Viajar</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div id="tohide" class="navbar-collapse collapse">
                            <div class="container-fluid">

                                <div class="navbar-right">
                                    <ul class="list-group hidden-md hidden-lg hidden-sm">
                                        <li><a href="index.php" id="dropdown-news"target="main_iframe" class="list-group-item"><span class="badge"><img src="img/noticias.png"></span>Noticias</a></li>
                                        <li><a href="#" class="list-group-item"><span class="badge"><img src="img/info.png"></span>Información</a></li>
                                        <li><a href="sports.php" id="dropdown-deportes" target="main_iframe" class="list-group-item"><span class="badge"><img src="img/deportes.png"></span>Deportes</a></li>
                                        <li><a href="#" id="dropdown-paises" target="main_iframe" class="list-group-item"><span class="badge"><img src="img/paises.png"></span>Países</a></li>
                                        <li><a href="athlete.php" id="dropdown-atletas" target="main_iframe" class="list-group-item"><span class="badge"><img src="img/atletas.png"></span>Atletas</a></li>
                                        <li><a href="#" id="dropdown-entradas" target="main_iframe" class="list-group-item"><span class="badge"><img src="img/entradas.png"></span>Entradas</a></li>
                                        <li><a href="#" id="dropdown-viajar" target="main_iframe" class="list-group-item"><span class="badge"><img src="img/viajar.png"></span>Viajar</a></li>
                                    </ul>
                                    <ul class="login-links" style="margin-right:30px;">
                                        <?php

                                            if (isset($_COOKIE["username"])) {
                                                echo "<li class='navbar-text'><a href='account.php'>".$_COOKIE['username']."</a></li>";
                                                echo "<li class='navbar-text'><a href='favs.php'>Favoritos</a></li>";
                                                echo "<li class='navbar-text'><a href='logout.php'>Salir</a></li>";
                                            } else {
                                                echo "<li class='navbar-text'><a href='login.php'>Iniciar sesión</a></li>";
                                                echo "<li class='navbar-text'><a href='register.php'>Registro</a></li>";
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

        <div class="container-fluid">
            <h1 class="page-title">Deportes</h1>
            <div class="row">
                <div class="col-md-4">
                    <?php include_once "scripts/fillSports.php"; getSportsGrid(); ?>
                </div>
                <div class="col-md-8">

                </div>
            </div>
        </div>
    </body>
</html>
