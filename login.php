<!DOCTYPE html>
<?php 
session_start(); 
?>
<html>
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Las etiquetas de arriba DEBEN ir primero. Cualquier otro contenido del head debe ir DESPUÉS de estas etiquetas-->
        <link href="css/custom-login.css" rel="stylesheet">
        <title>Iniciar sesión</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <script src="js/jquery-1.12.3.js"></script>

        <script>
            function login(){
                var username = document.getElementById("username").value;
                var password = document.getElementById("password").value;

                /*console.log(username);
                console.log(password);*/

                if (username==null || password==null){
                    window.alert("Por favor ingrese su nombre de usuario y contraseña");
                }

                var ajax = new XMLHttpRequest();
                ajax.open("POST", "login-user.php?username=" + username + "&password=" + password, true);

                ajax.onreadystatechange = function() {
                    if(ajax.readyState == 4 && ajax.status == 200) {

                       var datos = JSON.parse(ajax.responseText);
                       console.log(datos[0].valid);
                       
                        if (datos[0].valid == "true"){
                            switch (datos[0].rol){
                                case '1':// Si es Operador
                                $("#error").hide();
                                console.log(datos[0].rol);
                                location.href = "./cpanel/dashboard.php";
                                break;
                                case '2'://Si es Deportista
                                $("#error").hide();
                                console.log(datos[0].rol);
                                location.href = "./diary.php";
                                break;
                                case '3'://Si es Administrador
                                $("#error").hide();
                                console.log(datos[0].rol);
                                location.href = "./cpanel/dashboard.php";
                                break;
                            }
                        } else{
                            console.log("Contraseña incorrecta");
                            //window.alert("Usuario o contraseña incorrectos");
                            $("#error").show();
                        }
                    }
                }

                ajax.send();
            }
        </script>
    </head>
    <body>
        

        <div class="container-fluid">
                <div class="col-md-12">
                    
                        <h2 class="login-title">Iniciar sesión</h2>
                        <label for="username">Nombre de usuario</label>
                        <br>
                        <input name="username" id="username" type="username" class="form-control" placeholder="Nombre de usuario" onkeydown = "if (event.keyCode == 13) document.getElementById('sender').click()" required autofocus>
                        <label for="password">Contraseña</label>
                        <input name="password" id="password" type="password" class="form-control" placeholder="Contraseña" onkeydown = "if (event.keyCode == 13) document.getElementById('sender').click()" required>
                        <div class="checkbox">
                          <label>
                          <input name="remember" type="checkbox" value="remember-me"> Recordarme
                          </label>
                        </div>
                        <button id="sender" class="btn btn-lg btn-primary btn-block" onclick="login()">Iniciar sesión</button>
                            <br><p id="error" class="text-center btn-danger" hidden>Usuario o contraseña incorrectos</p>
                </div>
        </div>
    </body>
</html>
