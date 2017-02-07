<!DOCTYPE html>
<?php
            session_start(); 

            if(isset($_SESSION['username']) and $_SESSION['logged'] == 'true' and $_SESSION['cpanel'] == 'true' ) 
            { 
                // Lo dejas entrar a la pagina 
            } 
            else 
            {   
                // Usuario que no se ha logueado o no tiene acceso a este nivel. 
            header('Location: ../index.php');
            exit(); 
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
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/qr/qrcode.js"></script>

        <script src="../js/controles.js"></script>
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

        <script>
        function generarPass(){
            var pass = "";
            var caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for(var i=0; i<=7; i++){
                pass += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }

            document.getElementById("password").value = pass;
        }

        function crearUsuario(){
            $("#user-ok").hide();
            $("#user-error").hide();
            $("#qrcode").empty();
            var username = document.getElementById("username").value;
            var pass = document.getElementById("password").value;
            var mail = document.getElementById("email").value;
            var rol = document.getElementById("tipo").value;

            if(username == "" || pass == "" || mail == ""){
                alert("Por favor, escriba un nombre de usuario, una dirección de correo electrónico y genere una contraseña");
            }else{
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "../scripts/usuarios.php?q=addUser&user=" + username + "&pass=" + pass + "&mail=" + mail + "&rol=" + rol, true);
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText == "ok"){
                            var qrcode = new QRCode(document.getElementById("qrcode"), {
                            	text: "Nombre de usuario: " + username +"; Contraseña: " + pass + ";",
                            	width: 256,
                            	height: 256,
                            	colorDark : "#000000",
                            	colorLight : "#ffffff",
                            	correctLevel : QRCode.CorrectLevel.H
                            });console.log(xmlhttp.responseText);
                            $("#user-ok").show();
                        }else{
                            $("#user-error").show();console.log(xmlhttp.responseText);
                        }
                    }
                }
                xmlhttp.send();




            }
        }
        </script>
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
                        <li><a href="dashboard.php">Inicio</span></a></li>
                        <li><a href="sports.php">Deportes</a></li>
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
                    <ul class="nav nav-sidebar" id="sysmenu">
                        <li class="active"><a href="">Agregar usuario<span class="sr-only">(current)</span></a></li>
                        <li><a href="agendas.php">Gestionar agendas</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header" style="display:inline; margin-right: 20px;">Agregar usuario</h1>
                </div>
                <div class="col-sm-9 col-sm-offset-2">
                    <div class="col-md-5">
                        <label for="tipo">Tipo de usuario:</label>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="3">Administrador</option>
                            <option value="1">Operador</option>
                        </select><br>
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" name="username" id="username" class="form-control"><br>
                        <label for="password">Contraseña:</label><br>
                        <div class="input-group">
                          <input type="text" name="password" id="password" class="form-control" disabled>
                          <span class="input-group-btn">
                            <button class="btn btn-default" onclick="generarPass()">Generar</button>
                          </span>
                        </div>
                        <br>
                        <label for="email">Correo electrónico:</label>
                        <input type="text" name="email" id="email" class="form-control"><br>
                        <button class="btn btn-default pull-right" onclick="crearUsuario()">Crear</button><br><br><br>
                        <div id="user-ok" class="alert alert-success alert-dismissable" role="alert" hidden><span class="glyphicon glyphicon-ok"></span> Usuario creado correctamente</div>
                        <div id="user-error" class="alert alert-danger alert-dismissable" role="alert" hidden><span class="glyphicon glyphicon-remove"></span> Error al crear el usuario</div>
                    </div>
                    <div class="col-md-4">
                        <p class="text">Código QR:</p>
                        <div id="qrcode"><p class="text"><i>Ingrese un nombre de usuario y contraseña, y luego presione el botón "Crear"</i></p></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
