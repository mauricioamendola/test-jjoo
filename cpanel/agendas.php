<!DOCTYPE html>
<?php
            session_start(); 

            if(isset($_SESSION['username']) and $_SESSION['logged'] == 'true' and ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '3')){
                // Lo dejas entrar a la pagina 
            } 
            else 
            {   
                // Usuario que no se ha logueado 
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
        <script src="../js/bootstrap.min.js"></script>         <script src="../js/controles.js"></script>


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
            function fillSports(id){
                $("#sportsList option").remove();
                var xmlhttp = new XMLHttpRequest();
                //console.log("ID de país seleccionado2: " + id);
                xmlhttp.open("POST", "../scripts/fillSports.php?q=selectSport&countryid=" + id, true);
                //console.log("Estado del XmlHttpRequest2: " + xmlhttp.readyState);
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);
                         console.log("Contenido del XmlHttpRequest: " + xmlhttp.responseText);
                        document.getElementById('sportsList').innerHTML = xmlhttp.responseText;
                    }
                }
                //fillAthletes();
                xmlhttp.send();
            }

            function fillCountries(id){
                var xmlhttp = new XMLHttpRequest();
                //console.log("ID de torneo seleccionado: " + id);
                xmlhttp.open("POST", "../scripts/fillCountries.php?q=selectCountryTourny&tournyid=" + id, true);
                //console.log("Estado del XmlHttpRequest: " + xmlhttp.readyState);

                document.getElementById("tournyId").value=id;

                var valorTorneo = document.getElementById("tournyList").value;
                if(valorTorneo != 0){
                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var selectPaises = document.getElementById("countryList");
                            for (var i=0; i<selectPaises.length; i++){
                                selectPaises.remove(i);
                            }
                            document.getElementById('countryList').innerHTML = xmlhttp.responseText;
                            var cid = document.getElementById("countryList").value;
                            fillSports(cid);
                            document.getElementById("countryId").value = cid;
                            // console.log("ID Disciplina: " + document.getElementById("sportList").value);
                            // document.getElementById("sportId").value = document.getElementById("sportList").value;
                            //fillAthletes();
                        }
                    }
                    xmlhttp.send();
                } else {
                    var selectDelegacion = document.getElementById("countryList");
                    selectDelegacion.value = 0;
                    selectDelegacion.innerHTML = "Seleccione un torneo de la lista";
                }
            }

            function fillAthletes(){
                $("staff-table").hide();
                $("loading").show();
                var xmlhttp = new XMLHttpRequest();
                var delegacionId = document.getElementById("countryList").value;
                var sid = document.getElementById("sportsList").value;
                console.log("1ID Delegación: " + delegacionId);
                console.log("1ID Disciplina: " + sid);

                if (delegacionId != 0 && sid != 0){
                    //console.log("SELECT NombreDisciplina, R.NombrePersona, R.ApellidoPersona, R.IdPersona from Disciplina H, Categoria C, Equipo E, Conforma F, Deportista X, Participante P, Delegacion T, Persona R, Integra2 Z Where E.IdEquipo=F.IdEquipo And C.IdCategoria=E.IdCategoria And H.IdDisciplina=C.IdDisciplina And P.IdPersona=F.IdPersona And P.IdPersona=X.IdPersona And R.IdPersona=P.IdPersona And P.IdPersona=Z.IdPersona And T.IdDelegacion=Z.IdDelegacion And T.IdTorneo="+tournyId+" And Z.IdDelegacion="+delegacionId+" And H.IdDisciplina="+sid+" Group by NombrePersona, ApellidoPersona");
                    xmlhttp.open("POST", "../scripts/dataMgmt.php?q=poblarAtletaPorD&sid="+sid+"&did="+delegacionId, true);
                    console.log("ID Delegación: " + delegacionId);
                    console.log("ID Disciplina: " + sid);
                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            $("staff-table").show();
                            document.getElementById('athleteList').innerHTML = xmlhttp.responseText;
                            //console.log(xmlhttp.responseText);
                        }
                    }
                    xmlhttp.send();
                }
            }

            function checkAgenda(id){
                location.href = "veragenda.php?q=check&id=" + id;
            }
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
                        <li><a href="adduser.php">Agregar Admin/Operador</a></li>
                        <li class="active"><a href="agendas.php">Gestionar agendas <span class="sr-only">(current)</a></li>
                        <li><a href="audit.php">Ver historial de uso</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Agendas</h1>
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <p><b>Seleccione un torneo: </b></p>
                            <select id="tournyList" class="form-control" onchange="fillCountries(this.value);" width="100px">
                                <option value="0">Seleccione un torneo...</option>
                                <?php
                                    //include_once "../scripts/includes/Torneo.php";
                                    //include_once "../scripts/includes/dbcfg.php";
                                    $path = dirname(dirname(__FILE__));
                                    include_once $path.'/scripts/dbcfg.php';

                                    $dbusername="infoSelect";
                                    $dbpass="infoselectpass";
                                    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
                                    if ($connection->connect_error) {
                                        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
                                    } else {
                                        $connection->set_charset("utf8");
                                        $sql = "SELECT IdTorneo, NombreTorneo, FechaTorneo FROM torneo ORDER BY FechaTorneo DESC";
                                        /*$query = $connection->query($sql);*/
                            			$connection->set_charset("utf8");
                                        $result = mysqli_query($connection, $sql);
                                        while($row = $result->fetch_assoc()){
                            				echo "<option value='".$row['IdTorneo']."'>".$row['NombreTorneo']." ".$row['FechaTorneo']."";
                            			}
                                    }
                                    $connection->close();
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <p><b>Seleccione un país</b></p>
                            <select class="form-control" onchange="fillSports(this.value);" id="countryList">
                                    <option value="0">Seleccione un torneo de la lista</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <p><b>Seleccione un deporte</b></p>
                            <select class="form-control" id="sportsList" onchange="">
                                <option value="0">Seleccione un deporte o torneo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <p><b> </b></p>
                            <button type="button" onclick="fillAthletes()" class="btn btn-default">Buscar</button>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="col-md-10 col-md-offset-2">
                    <div class="table-responsive">
                    <table class="table" id="staff-table">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ver agenda</th>
                            <tr>
                        </thead>
                        <tbody id="athleteList">

                        </tbody>
                    </table>
                </div>
                </div>
                <div id="loading" width="100px" height="100px" class="col-md-3 col-md-offset-5" hidden>
                    <div id="loading-container" style="background-color: #272727; border-radius:10px; padding:20px">
                        <center>
                            <text class="text" style="color:#FFFFFF; font-family: sans-serif; font-size: 20px;">Cargando&nbsp&nbsp&nbsp</text>
                            <img src="../img/loading-icon.gif" id="loading-ico" width="30px" height="30px">
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <input type="text" id="tournyId" hidden></option>
        <input type="text" id="countryId" hidden></option>
        <input type="text" id="sportId" hidden></option>
    </body>
</html>
