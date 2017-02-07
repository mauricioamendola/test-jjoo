<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Las etiquetas de arriba DEBEN ir primero. Cualquier otro contenido del head debe ir DESPUÉS de estas etiquetas-->
        <link href="css/custom-login.css" rel="stylesheet">
        <title>Registro</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <script>
            function verifyPass(){
                if (document.getElementById("pass2").value != document.getElementById("password").value) {
                    document.getElementById("pass2").style.borderColor = "#CC0000";
                } else {
                    document.getElementById("pass2").style.borderColor = "#d9d9d9";
                }
            }
        </script>
    </head>
    <body>

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-8">
                    <form class="form-group-sm" action="register-user.php" method="post">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input name="username" id="username" class="form-control form-field" type="text">
                        <br>
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input name="email" id="email" class="form-control form-field" type="email">
                        <br>
                        <label for="firstname" class="form-label">Nombre</label>
                        <input name="firstname" id="firstname" class="form-control form-field" type="text">
                        <br>
                        <label for="lastname" class="form-label">Apellido</label>
                        <input name="lastname" id="lastname" class="form-control form-field" type="text">
                        <br>
                        <label for="password" class="form-label">Contraseña</label>
                        <input name="password" id="password" class="form-control form-field" type="password">
                        <br>
                        <label for="pass2" class="form-label">Contraseña (repetir)</label>
                        <input name="pass2" id="pass2" class="form-control form-field" type="password" onkeyup="verifyPass()">
                        <p id="aviso-pass">Las contraseñas no coinciden</p>
                        <br>

                        <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
                    </form>
                </div><!--col-md-8-->

                <div class="col-md-4"> <!--Botones de redes sociales-->

                    <!--Botón de Google-->
                    <script src="https://apis.google.com/js/platform.js" async defer></script>
                    <meta name="google-signin-client_id" content="895897950011-2fk31nr0ebura0vkoi37d53suop3tphf.apps.googleusercontent.com">

                    <div class="g-signin2" data-width="auto" data-longtitle="true" data-onsuccess="onSignIn"></div>
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

                </div><!--col-md-4-->

                <span id="separator"></span>


            </div><!--row-->
        </div> <!--window-container-->
    </body>
</html>
