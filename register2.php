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
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

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
                                    <li><a href="#" id="dropdown-news" target="main_iframe">Noticias</a></li>
                                    <li><a href="#" id="dropdown-info" target="main_iframe">Información</a></li>
                                    <li><a href="#" id="dropdown-deportes" target="main_iframe">Deportes</a></li>
                                    <li><a href="#" id="dropdown-paises" target="main_iframe">Países</a></li>
                                    <li><a href="#" id="dropdown-atletas" target="main_iframe">Atletas</a></li>
                                    <li><a href="#" id="dropdown-entradas" target="main_iframe">Entradas</a></li>
                                    <li><a href="#" id="dropdown-viajar" target="main_iframe">Viajar</a></li>
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
        <div class="register-form-container">
            <h1 class="page-title">Registro</h1>
            <br>
            <div class="register-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <form class="form-group-sm" action="register-user.php" method="post">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input name="username" id="username" class="form-control form-field" type="text">
                                <br>
                                <label for="username" class="form-label">Correo electrónico</label>
                                <input name="username" id="username" class="form-control form-field" type="text">
                                <br>
                                <label for="username" class="form-label">Contraseña</label>
                                <input name="username" id="username" class="form-control form-field" type="password">
                                <br>
                                <label for="username" class="form-label">Contraseña (repetir)</label>
                                <input name="username" id="username" class="form-control form-field" type="password">
                                <br>

                                <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h1 class="page-title">Iniciar sesión con redes sociales</h2>
                            <!--Botón de Google-->
                            <script src="https://apis.google.com/js/platform.js" async defer></script>
                            <meta name="google-signin-client_id" content="895897950011-2fk31nr0ebura0vkoi37d53suop3tphf.apps.googleusercontent.com">

                            <div class="g-signin2" data-width="200" data-longtitle="true" data-onsuccess="onSignIn"></div>
                            <script>
                                function onSignIn(googleUser) {
                                    // Useful data for your client-side scripts:
                                    var profile = googleUser.getBasicProfile();
                                    console.log("ID: " + profile.getId()); // Don't send this directly to your server!
                                    console.log('Nombre completo: ' + profile.getName());
                                    console.log('Nombre: ' + profile.getGivenName());
                                    console.log('Apellido: ' + profile.getFamilyName());
                                    console.log("URL de imagen de perfil: " + profile.getImageUrl());
                                    console.log("Email: " + profile.getEmail());

                                    // The ID token you need to pass to your backend:
                                    var id_token = googleUser.getAuthResponse().id_token;
                                    console.log("ID Token: " + id_token);
                                };
                            </script>
                            <a href="#" onclick="signOut();">Sign out</a>
                            <script>
                            function signOut() {
                                var auth2 = gapi.auth2.getAuthInstance();
                                auth2.signOut().then(function () {
                                    console.log('User signed out.');
                                });
                            }
                            </script>

                            <!--Login de Facebook-->
                            <div id="fb-root"></div>
                            <script>
                                (function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s); js.id = id;
                                    js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.6&appId=1623093934676427";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));
                            </script>
                            <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>

                            <!--Login de Twitter-->
                            <a href="scripts/process.php" name="twitter-login"><br>Iniciar sesion con Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
