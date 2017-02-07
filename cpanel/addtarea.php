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
            function fillYears(){
                var today = new Date();
                var year = today.getFullYear();

                for (i=year; i<(year+30); i++){
                    var yearSelector = document.getElementById("years");
                    var option = document.createElement('option');
                    option.value = i;
                    option.innerHTML = i;
                    yearSelector.appendChild(option);
                }
            }

            function esBisiesto(year){
              return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
            }

            function changeDays(mes){
                var dia = document.getElementById("day");
                switch(mes-1){
                    case 0:
                        dia.max = 31;
                        break;
                    case 1:
                        if(esBisiesto(document.getElementById("fecha"))){
                            dia.max = 29;
                            break;
                        } else{
                            dia.max = 28;
                            break;
                        }
                    case 2:
                    case 4:
                    case 6:
                    case 7:
                    case 9:
                    case 11:
                        dia.max = 31;
                        break;
                    default:
                        dia.max = 30;
                        break;
                }
                if(dia.value>dia.max){
                    dia.value=dia.max;
                }
            }

            

            function ingresarDatos(){
                $("#warning-datos").hide();
                var idLugar = document.getElementById("lugar").value;
                var idPersona = document.getElementById("idPersona").value;
                var tipoActividad = document.getElementById("tipoActividad").value;
                var observaciones = document.getElementById("observaciones").value;
                var month = document.getElementById("month").value;
                var day = document.getElementById("day").value;
                var date = document.getElementById("years").value + "-" + month + "-" + day;
                var time = document.getElementById("hora").value;

                if ((idLugar == 0) || (month === "undefined") || (day === "undefined") || (hora === "undefined") || (tipoActividad === "undefined") ){
                    $("#warning-datos").show();
                    //console.log("error");
                } else {
                    window.location.replace("../scripts/dataMgmt.php?q=insertActividad&idpersona="+idPersona+"&idlugar=" + idLugar + "&actividad=" + tipoActividad + "&observaciones=" + observaciones + "&date=" + date +"&time=" + time );
                }
            }
        </script>

        <style>
            #warning-datos{
                padding: 30px;
                background-color: #ffe6e6;
                border-radius: 10px;
                border: 1px solid #ff6666;
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body onload="fillYears(); $('#warning-datos').hide();">
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
                        <h4>Agregar tarea para <mark><?php
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
                        ?></mark></h4><input id="idPersona" value="<?php echo $_REQUEST['id']; ?>" hidden></input>
                        <p id="warning-datos" class="text-danger">Asegúrese de ingresar todos los datos</p>
                        <h3>Datos</h3>
                        <form>
                            <br>
                            <label for="fecha">Fecha:</label>
                            <select class="form-control" id="years" name="fecha" style="width:100px; display:inline" required></select>
                            <input type="number" name="month" id="month" min="01" max="12" class="form-control" style="width:100px; display:inline" placeholder="MM" onchange="changeDays(this.value)" required></input>
                            <input type="number" name="day" id="day" min="01" class="form-control" style="width:100px; display:inline" placeholder="DD" required></input>
                            <br><br>
                            <label for="hora">Hora:</label>
                            <input type="time" name="hora" id="hora" min="01" max="12" class="form-control" style="width:100px;  display:inline" placeholder="HM"required></input>
                            <br><br>
                            <label for="tipoActividad">Tipo de actividad:</label>
                            <select id="tipoActividad" name="tipoActividad" class="form-control" style="width:233px;" required>
                                <option selected value='practica'>Pr&aacute;ctica</option>
                                <option value='competencia'>Competencia</option>
                                <option value='asistencia'>Asistencia</option>
                                <option value='recreativa'>Recreativa</option>
                                <option value='otros'>Otros</option>
                            </select>
                            <br><label for="lugar">Lugar:</label>
                            <select id="lugar" name="lugar" class="form-control" style="width:260px;" required>
                                <?php
                                $sql2 = "SELECT IdLugar, NombreLugar FROM Lugar";
                                $result2 = mysqli_query($connection, $sql2);
                                while($row2 = $result2->fetch_assoc()){
                                    if($row2['IdLugar']=='1'){
                                        echo "<option value='".$row2['IdLugar']."' selected>".$row2['NombreLugar']."</option>";
                                    }else{
                                        echo "<option value='".$row2['IdLugar']."'>".$row2['NombreLugar']."</option>";
                                    }
                                }
                                $connection->close();
                                ?>
                            </select>
                            <div id="divLugares" hidden>
                                <br><br><label for="listaLugares">Lugar:</label>
                                <select id="listaLugares" name="listaLugares" class="form-control" style="width:260px; display:inline" onchange="cargarLugares(this.options[this.selectedIndex].value)" required>
                                    <option value="0">Seleccione...</option>
                                </select>
                            </div>
                        </form>
                        <br><br><label for="observaciones">Observaciones:</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" style="width:360px" maxlength="250" rows="5" cols="50" required></textarea>
                        <br><button type="button" class="btn btn-success" onclick="ingresarDatos()">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
