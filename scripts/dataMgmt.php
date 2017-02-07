<?php
    include_once "dbcfg.php";
    include_once "includes/Torneo.php";
    include_once "includes/Lugar.php";
    include_once "includes/deportistas.php";
    include_once "includes/disciplinas.php";
    include_once "includes/Delegacion.php";
    include_once "includes/participantes.php";
    include_once "includes/Agenda.php";

    function addTournament($tournyYear, $tournyName){
        /*$dbuser = "toInsert";
        $dbpass = "toInsert";

        echo "entro en funcion<br>";

        $conexion = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

        if ($conexion->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            echo "entro en sql<br>";
            mysqli_select_db($conexion, DBNAME);
            $sql = "INSERT INTO torneo VALUES (0, '".utf8_decode($tournyName)."', ".$tournyYear.");";
            $res = $conexion->query($sql) or die(mysqli_error($conexion));
            $conexion->close();
        }*/
        $torneo = new Torneo(0, $tournyName, $tournyYear);
        $torneo->Insert_Torneo;
        header("Location: ../cpanel/tournaments.php?q=add");
    }

    function updateTourny($id, $name, $year){
        $dbuser = "toUpdate";
        $dbpass = "toUpdate";

        echo "entro en funcion<br>";

        $update = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
        $update->set_charset("utf8");

        if ($update->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            echo "entro en sql<br>";
            mysqli_select_db($update, DBNAME);
            $sql = "UPDATE torneo set NombreTorneo='".utf8_decode($name)."', FechaTorneo='$year' WHERE IdTorneo=".intval($id)."";
            echo $sql."<br>";
            /*$query = $connection->query($sql);*/
            $res = $update->query($sql) or die(mysqli_error($update));
            $update->close();
        }
        header("Location: ../cpanel/tournaments.php?q=update");
    }

    function deleteTourny($id){
        $dbusername = "toDelete";
        $dbpass = "toDelete";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        $connection->set_charset("utf8");
        echo "entro en funcion <br>";

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "DELETE FROM torneo WHERE idtorneo=".$id.";";
            echo $sql;
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
            header("Location: ../cpanel/tournaments.php?q=deleteSuccess");
        }
    }

    function fillTournyDropdown($idT){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdTorneo, FechaTorneo, NombreTorneo FROM torneo ORDER BY FechaTorneo DESC, NombreTorneo ASC";
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if($idT==NULL){
            
            while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['IdTorneo']."'>".$row['FechaTorneo']." - ".$row['NombreTorneo']."</option>";
        }
        }else{
            
            while ($row = $result->fetch_assoc()) {
                if($idT==$row['IdTorneo']){
                    echo "<option selected value='".$row['IdTorneo']."'>".$row['FechaTorneo']." - ".$row['NombreTorneo']."</option>";
                }else{
                    echo "<option value='".$row['IdTorneo']."'>".$row['FechaTorneo']." - ".$row['NombreTorneo']."</option>";
                }
            }

        }
        $connection->close();
        
    }

    function fillCommittees(){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        


        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $connection->set_charset("utf8");
            $sql = "SELECT IdDelegacion, NombreDelegacion, d.IdTorneo, nombretorneo, FechaTorneo  FROM delegacion d, torneo t WHERE t.idtorneo=d.idtorneo";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['IdDelegacion']."</td>";
            $nombre = $row['NombreDelegacion'];
            $uri = "moddelegacion.php?id=".$row['IdDelegacion']."&name=".$row['NombreDelegacion']."";
            $cat = "integrantes.php?id=".$row['IdDelegacion']."&name=".$row['NombreDelegacion']."";
            echo "<td>".$row['NombreDelegacion']."</td>";
            echo "<td>(".$row['FechaTorneo'].")".$row['nombretorneo']."</td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDelete(".$row['IdDelegacion'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "<td><button type='button' class='btn btn-success btn-xs' onclick='location.href=\"".$cat."\"'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspGestionar Integrantes</button></td>";
            echo "</tr>";
        }
    }

    function addCommittee($torneo, $nombre){
        if ($nombre == null){
          header("Location: ../cpanel/committees.php?q=delegacionvacio");
        }
        else{
            $dbuser = "toInsert";
            $dbpass = "toInsert";

            echo "entro en funcion<br>";

            $conexion = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
            $connection->set_charset("utf8");

            if ($conexion->connect_error) {
                die("La conexión a la base de datos ha fallado." . $connection->connect_error);
            } else {
                echo "entro en sql<br>";
                mysqli_select_db($conexion, DBNAME);
                $sql = "INSERT INTO delegacion VALUES (0, '".utf8_decode($nombre)."', ".$torneo.");";
                echo $sql."<br>";
                /*$query = $connection->query($sql);*/
                $res = $conexion->query($sql) or die(mysqli_error($conexion));
                $conexion->close();
            }
            header("Location: ../cpanel/committees.php?q=add");
            }
        }

    function deleteCommittee($id){
        $dbusername = "toDelete";
        $dbpass = "toDelete";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        $connection->set_charset("utf8");
        echo "entro en funcion <br>";

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "DELETE FROM delegacion WHERE iddelegacion=".$id.";";
            echo $sql;
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
            header("Location: ../cpanel/committees.php?q=deleteSuccess");
        }
    }

    function updateCommittee($id, $tourny, $name){
        $dbuser = "toUpdate";
        $dbpass = "toUpdate";

        echo "entro en funcion<br>";

        $update = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
        $update->set_charset("utf8");

        if ($update->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            echo "entro en sql<br>";
            mysqli_select_db($update, DBNAME);
            $sql = "UPDATE delegacion set NombreDelegacion='".utf8_decode($name)."', IdTorneo='$tourny' WHERE IdDelegacion=".intval($id)."";
            echo $sql."<br>";
            /*$query = $connection->query($sql);*/
            $res = $update->query($sql) or die(mysqli_error($update));
            $update->close();
        }
        header("Location: ../cpanel/committees.php?q=update");
    }

    function fillMembers($id){

        $dbuser = "toUpdate";
        $dbpass = "toUpdate";
        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");


        echo "<form method='post' enctype='multipart/form-data' role='form'>";

            echo "<div class='row'>";
            echo "<div id='pais' class='form-group col-md-3'>";
            echo "<label for='CountryName' class='form-label'>Pa&iacute;s:</label>";
            echo "<select name='CountryName' id='selectedCountry' class='form-control' onchange=\"fillParticipantes1(this.value,document.getElementById('sexo1').value)\">";             
                    include_once("/fillCompetitor.php"); 
                    CompletaPaises('');    
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div id='sexo' class='form-group col-md-3'>
                        <label for='sexo' class='form-label'>Sexo</label>
                        <select class='form-control' name='sexo' id='sexo1' onchange=\"fillParticipantes1(document.getElementById('selectedCountry').value,this.value)\">"; 
                    echo "  <option value='mujer'>Mujer</option>
                            <option value='hombre' selected>Hombre</option>"
                          ;
                    echo "</select>";
            echo "</div>";
            echo "</div>";
         //Participantes de la delegacion
            echo "<div id='final' class='form-group'>";
            echo "<div class='col-md-6'>";
            echo "<label for='SelectedCompetitor' class='form-label'>Participantes disponibles:</label>";
            echo "<select class='form-control' size='10' id='selectedCompetitor' name='selectedCompetitor'>";
            echo "</select>";
            echo "<p class='btn-lg btn-success  glyphicon glyphicon-arrow-right' onclick='addMember()''></p>";
            echo "<br><br>";
            echo "</div>";
            //Participantes Preseleccionados
            
            $sql3 = "SELECT dep.IdPersona, NombrePersona, ApellidoPersona, sexo, nombrepais, 'Deportista' as tipo FROM persona per, participante par, delegacion d, integra2 i, pais c, deportista dep
                WHERE par.idpersona = per.idpersona
                AND par.idpersona = i.idPersona
                AND par.idpais = c.idpais
                AND dep.idpersona =par.idpersona
                AND d.iddelegacion = i.iddelegacion
                AND d.iddelegacion = $id
                UNION
                SELECT pers.IdPersona, NombrePersona, ApellidoPersona, sexo, nombrepais, 'Personal' as tipo FROM persona per, participante par, delegacion d, integra2 i, pais c, personal pers
                WHERE par.idpersona = per.idpersona
                AND par.idpersona = i.idPersona
                AND par.idpais = c.idpais
                AND pers.idpersona =par.idpersona
                AND d.iddelegacion = i.iddelegacion
                AND d.iddelegacion = $id";

                $result3 = mysqli_query($connection, $sql3);

                if (!$result3) {
                    printf("Error1: %s\n", mysqli_error($connection));
                    exit();
                }
            echo "<div class='col-md-6'>";
            echo "<label for='preseleccionados' class='form-label'>Intregrantes Preseleccionados:</label>";
            echo "<select class='form-control' size='10' id='preseleccionados'>";
                
                while ( $row = $result3->fetch_assoc() ){
                        echo "<option value='".$row['IdPersona']."'>".$row['NombrePersona']." ".$row['ApellidoPersona']."  [".$row['sexo']."]->(".$row['tipo'].") /".$row['nombrepais']."</option>";  
                }
            echo "</select>";
            echo "</div>";
            echo "<div class='col-md-6'>";
            echo "<p class='btn-lg btn-danger glyphicon glyphicon-arrow-left' onclick='removeMember()'></p>";
            echo "</div>";
            echo "<br><br><br>";
            echo "<div class='form-group col-md-10' id='Final'>";
            echo "<br>";
            echo "<input type='hidden' name='iddelegacion' id='iddelegacion' value='".$id."'>";
            echo "<button type='button' class='btn btn-success btn-lg' value='Finalizar Gestion' name='submit' onclick='readPreselections()'>Finalizar Gestion</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";


        echo "</form>";
        echo "<script>

                window.onload = function() {
                 
                fillParticipantes(document.getElementById('selectedCountry').value,document.getElementById('sexo1').value);
                
            }
            
            </script>";

    }
    function fillParticipantes($pais,$sexo){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");
        $sexo=$connection->real_escape_string($sexo);
        $pais=$connection->real_escape_string($pais);

        mysqli_select_db($connection, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else {
            
                $sql = "SELECT dep.IdPersona, NombrePersona, ApellidoPersona, sexo, nombrepais, 'Deportista' as tipo 
                FROM persona per, participante par, delegacion d, integra2 i, pais c, deportista dep
                WHERE par.idpersona = per.idpersona
                AND par.idpersona = i.idPersona
                AND par.idpais = c.idpais
                AND dep.idpersona =par.idpersona
                AND d.iddelegacion = i.iddelegacion
                AND per.sexo='$sexo'
                AND par.IdPais='$pais'
                UNION
                SELECT pers.IdPersona, NombrePersona, ApellidoPersona, sexo, nombrepais, 'Personal' as tipo 
                FROM persona per, participante par, delegacion d, integra2 i, pais c, personal pers
                WHERE par.idpersona = per.idpersona
                AND par.idpersona = i.idPersona
                AND par.idpais = c.idpais
                AND pers.idpersona =par.idpersona
                AND d.iddelegacion = i.iddelegacion
                AND sexo = 'sexo'
                AND par.idpais = '$pais'";
            

            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("   Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        while ($row = $result->fetch_assoc()) {
           echo "<option value='".$row['IdPersona']."'>".$row['NombrePersona']." ".$row['ApellidoPersona']."  [".$row['sexo']."]->(".$row['tipo'].") /".$row['nombrepais']."</option>";  
             
        }
        $connection->close();
    }

    function modMembers($iddelegacion1,$atletas1){

        $iddelegacion=json_decode($iddelegacion1);
        $atletas=json_decode($atletas1);/*es el array de integrantes de la delegacion*/
        $participantes= new participantes();

        foreach($atletas as $participante){
            $participante1= new Participante($participante,'','','','','','','','');
            $participantes->insertar($participante1);
        }

        $delegacion=new Delegacion($iddelegacion,'','','',$participantes);
        $delegacion->insertar_integrantes();
        header("Location: ../cpanel/committees.php?q=Membersupdated");


    }

    function fillSportsDropdown($id){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else{
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdDisciplina, NombreDisciplina FROM disciplina ORDER BY NombreDisciplina";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        if($id==NULL){
            
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['IdDisciplina']."'>".$row['NombreDisciplina']."</option>";
            }

        }
        else{

            while ($row = $result->fetch_assoc()) {
                if($id==$row['IdDisciplina']){
                    $torneo = urlencode($row['NombreDisciplina']);
                    echo "<option selected value='".$row['IdDisciplina']."'>".$row['NombreDisciplina']."</option>";
                }
                else{
                    $torneo = urlencode($row['NombreDisciplina']);
                    echo "<option value='".$row['IdDisciplina']."'>".$row['NombreDisciplina']."</option>";
                }
            }
        }
    }


    function fillServiciosDropdown(){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT L.IdLugar, S.TipoServicio FROM Servicio S, Lugar L WHERE L.IdLugar = S.IdLugar";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        while ($row = $result->fetch_assoc()) {
            $torneo = urlencode($row['TipoServicio']);
            echo "<option  value='".$row['IdLugar']."'>".utf8_encode($row['TipoServicio'])." - ".utf8_encode($row['IdLugar'])."</option>";
        }
    }
    function fillCategoriesDropdown($id,$idcat){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdCategoria, NombreCategoria, Genero FROM categoria WHERE IdDisciplina=$id ORDER BY NombreCategoria";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if($idcat==NULL){
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['IdCategoria']."'>".$row['NombreCategoria']." - (".$row['Genero'].")</option>";
            }
        }
        else{

            while ($row = $result->fetch_assoc()) {
                if($idcat==$row['IdCategoria']){
                    
                     echo "<option selected value='".$row['IdCategoria']."'>".$row['NombreCategoria']." - (".$row['Genero'].")</option>";
                }
                else{
                    
                     echo "<option value='".$row['IdCategoria']."'>".$row['NombreCategoria']." - (".$row['Genero'].")</option>";
                }
            }
        }
    }

    function fillPlacesdropdown($id){
        
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else{
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdLugar, NombreLugar FROM lugar ORDER BY NombreLugar";
            
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if($id==NULL){
            
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['IdLugar']."'>".$row['NombreLugar']."</option>";
            }
        }
        else{
            while ($row = $result->fetch_assoc()) {
                if($id==$row['IdLugar']){
                     echo "<option selected value='".$row['IdLugar']."'>".$row['NombreLugar']."</option>";
                }
                else{
                   
                    echo "<option value='".$row['IdLugar']."'>".$row['NombreLugar']."</option>";    
                }
            }
        }

    }
    function getPlacesTable(){

        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        $connection->set_charset("utf8");
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $sql = "SELECT idlugar, nombrelugar, direccionlugar, sitioweblugar
                    FROM lugar";
                    
            
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }


        while ($row = $result->fetch_assoc()){

            echo "<tr>";
            echo "<td>".$row['idlugar']."</td>";
            echo "<td>".$row['nombrelugar']."</td>";
            echo "<td>".$row['direccionlugar']."</td>";
            echo "<td><a href='http://".$row['sitioweblugar']."'>".$row['sitioweblugar']."'</a></td>";
            $placename = urlencode($row['nombrelugar']);
            $uri = "modplace.php?id=".$row['idlugar']."&name=".$placename."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDelete(".$row['idlugar'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "</tr>";     
        }
        $connection->close();
    }

    function fillAthletes($torneo, $categoria){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdEquipo, NombreEquipo FROM equipo WHERE IdTorneo=$torneo AND IdCategoria=$categoria ORDER BY NombreEquipo";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        $goodQuery = false;
        while ($row = $result->fetch_assoc()) {
            $goodQuery = true;
            echo "<tr>";
            echo "<td style='padding-bottom: 5px;'>".$row['IdEquipo']."</td>";
            $nombre = urlencode($row['NombreEquipo']);
            $uri = "modteam.php?id=".$row['IdEquipo']."&name=".$nombre."";
            echo "<td style='padding-bottom: 5px;'>".utf8_encode($row['NombreEquipo'])."</td>";
            echo "<td style='padding-bottom: 5px;'><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td style='padding-bottom: 5px;'><button type='button' class='btn btn-link btn-xs' onclick='confirmDelete(".$row['IdEquipo'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "<td style='padding-bottom: 5px;'><button type='button' class='btn btn-success btn-xs' id='".$row['IdEquipo']."' onclick='changeTable(this.id)'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspSeleccionar</button></td>";
            echo "</tr>";
        }

        if ($goodQuery == false){
            echo "<p><i>No se encontraron atletas de acuerdo a los parámetros seleccionados</i></p>";
        }
    }

    function fillAthletes01($torneo, $categoria){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT E.IdEquipo, NombrePersona, ApellidoPersona, NombreDelegacion, Sexo, PesoDeportista, AlturaDeportista, NombreTorneo
                    FROM Equipo E, Delegacion DL, Deportista D, Conforma K, Participante P, Persona G, Torneo T, Integra2 X
                    WHERE T.IdTorneo=$torneo
                        AND E.IdCategoria=$categoria
                        AND E.IdEquipo=K.IdEquipo
                        AND K.IdPersona = P.idPersona
                        AND X.IdDelegacion = DL.IdDelegacion
                        AND X.IdPersona = P.IdPersona
                        AND DL.IdTorneo = T.IdTorneo
                        AND P.idPersona=D.idPersona
                        AND D.IdPersona=P.idPersona
                        AND P.idPersona = G.idPersona
                    ORDER BY NombrePersona";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);

            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        $goodQuery = false;
        while ($row = $result->fetch_assoc()) {
            $goodQuery = true;
            echo "<tr>";
            echo "<td style='padding-bottom: 15px;' align = 'center'>".utf8_encode($row['NombrePersona'])."</td>";
            echo "<td style='padding-bottom: 15px;' align = 'center'>".utf8_encode($row['ApellidoPersona'])."</td>";
            echo "<td style='padding-bottom: 15px;' align = 'center'>".utf8_encode($row['Sexo'])."</td>";
            echo "<td style='padding-bottom: 15px;' align = 'center'>".utf8_encode($row['NombreDelegacion'])."</td>";
            echo "<td style='padding-bottom: 15px;' align = 'center'>".utf8_encode($row['PesoDeportista'])."</td>";
            echo "<td style='padding-bottom: 15px;' align = 'center'>".utf8_encode($row['AlturaDeportista'])."</td>";
            echo "</tr>";
        }

        if ($goodQuery == false){
            echo "<td colspan='5' align='center'><i>No se encontraron atletas de acuerdo a los parámetros seleccionados</i></td>";
        }
    }

    function fillHistoricAthletes($torneo, $categoria){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT DL.NombreDelegacion, G.NombrePersona, G.ApellidoPersona, DI.NombreDisciplina, CA.NombreCategoria, CA.Genero, H.TipoHistorico
                    FROM Persona G, Participante J, Deportista D, Conforma K, Equipo E, Torneo T, Historico H, Competidor C, Delegacion DL, Categoria CA, Disciplina DI, Integra2 X
                    WHERE T.IdTorneo = $torneo
                        AND CA.IdCategoria = $categoria
                        AND H.TipoHistorico = 'oro'
                        AND DI.IdDisciplina = CA.IdDisciplina
                        AND CA.IdCategoria = E.IdCategoria
                        AND H.IdCompetidor = C.IdCompetidor
                        AND C.IdEquipo = E.IdEquipo
                        AND E.IdEquipo = K.IdEquipo
                        AND K.IdPersona = J.IdPersona
                        AND D.IdPersona = J.IdPersona
                        AND J.IdPersona = G.IdPersona
                        AND X.IdDelegacion =  DL.IdDelegacion
                        AND X.IdPersona = J.IdPersona

                    UNION
                        SELECT DL.NombreDelegacion, G.NombrePersona, G.ApellidoPersona, DI.NombreDisciplina, CA.NombreCategoria, CA.Genero, H.TipoHistorico
                        FROM Persona G, Participante J, Deportista D, Conforma K, Equipo E, Torneo T, Historico H, Competidor C, Delegacion DL, Categoria CA, Disciplina DI, Integra2 X
                        WHERE T.IdTorneo = $torneo
                            AND CA.IdCategoria = $categoria
                            AND H.TipoHistorico = 'plata'
                            AND DI.IdDisciplina = CA.IdDisciplina
                            AND CA.IdCategoria = E.IdCategoria
                            AND H.IdCompetidor = C.IdCompetidor
                            AND C.IdEquipo = E.IdEquipo
                            AND E.IdEquipo = K.IdEquipo
                            AND K.IdPersona = J.IdPersona
                            AND D.IdPersona = J.IdPersona
                            AND J.IdPersona = G.IdPersona
                            AND X.IdDelegacion =  DL.IdDelegacion
                            AND X.IdPersona = J.IdPersona

                    UNION
                        SELECT DL.NombreDelegacion, G.NombrePersona, G.ApellidoPersona, DI.NombreDisciplina, CA.NombreCategoria, CA.Genero, H.TipoHistorico
                        FROM Persona G, Participante J, Deportista D, Conforma K, Equipo E, Torneo T, Historico H, Competidor C, Delegacion DL, Categoria CA, Disciplina DI, Integra2 X
                        WHERE T.IdTorneo = $torneo
                                AND CA.IdCategoria = $categoria
                                AND H.TipoHistorico = 'bronce'
                                AND DI.IdDisciplina = CA.IdDisciplina
                                AND CA.IdCategoria = E.IdCategoria
                                AND H.IdCompetidor = C.IdCompetidor
                                AND C.IdEquipo = E.IdEquipo
                                AND E.IdEquipo = K.IdEquipo
                                AND K.IdPersona = J.IdPersona
                                AND D.IdPersona = J.IdPersona
                                AND J.IdPersona = G.IdPersona
                                AND X.IdDelegacion =  DL.IdDelegacion
                                AND X.IdPersona = J.IdPersona";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);

            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        $goodQuery = false;
        while ($row = $result->fetch_assoc()) {
            $goodQuery = true;
            echo "<tr>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['NombreDelegacion'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['NombrePersona'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['ApellidoPersona'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['TipoHistorico'])."</td>";
            echo "</tr>";
        }

        if ($goodQuery == false){
            echo "<td colspan='5' align='center'><i>No se encontraron atletas de acuerdo a los parámetros seleccionados</i></td>";
        }
    }

    function fillHistoricCommittes($torneo){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT DL.NombreDelegacion, COUNT(case  when H.TipoHistorico = 'oro' then 1 end) as oro , COUNT(case  when H.TipoHistorico = 'plata' then 1 end) as plata, COUNT(case  when H.TipoHistorico = 'bronce' then 1 end) as bronce
                            FROM Persona G, Participante J, Deportista D, Conforma K, Equipo E, Torneo T, Historico H, Competidor C, Delegacion DL, Integra2 I
                            WHERE DL.IdTorneo = $torneo
                                AND DL.IdTorneo = T.IdTorneo
                                AND H.IdCompetidor = C.IdCompetidor
                                AND C.IdEquipo = E.IdEquipo
                                AND E.IdEquipo = K.IdEquipo
                                AND K.IdPersona = J.IdPersona
                                AND D.IdPersona = J.IdPersona
                                AND J.IdPersona = G.IdPersona
                                AND I.IdDelegacion =  DL.IdDelegacion
                                AND I.IdPersona = J.IdPersona
                            GROUP BY DL.IdDelegacion";


            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);

            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        $goodQuery = false;
        while ($row = $result->fetch_assoc()) {
            $goodQuery = true;
            echo "<tr>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['NombreDelegacion'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['oro'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['plata'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['plata'])."</td>";

                echo "</tr>";
        }

        if ($goodQuery == false){
            echo "<td colspan='5' align='center'><i>No se encontraron datos de acuerdo a los parámetros seleccionados</i></td>";
        }
    }

    
    function FillReglamento($disciplina){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdDisciplina, NombreDisciplina, DescripcionDisciplina, LinkReglamento, LinkHistoria
                    FROM Disciplina  D
                    WHERE IdDisciplina = $disciplina";


            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);

            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        $goodQuery = false;
        $img="img/sport-icon/";
        while ($row = $result->fetch_assoc()) {
            $goodQuery = true;
            echo "<tr>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'><img src='".$img."".$row['IdDisciplina'].".png'></td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['NombreDisciplina'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'>".utf8_encode($row['DescripcionDisciplina'])."</td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'><a href='".utf8_encode($row['LinkReglamento'])."'><img src='img/info.png'></a></td>";
            echo "<td style='padding-bottom: 15px; vertical-align:middle;' align = 'center'><a href='".utf8_encode($row['LinkHistoria'])."'><img src='img/info.png'></a></td>";
            echo "</tr>";
        }

        if ($goodQuery == false){
            echo "<td colspan='5' align='center'><i>No se encontraron datos de acuerdo a los parámetros seleccionados</i></td>";
        }
    }

    function addPlace($nombre, $dir, $web, $lat, $lon, $tipo){
        $lugar = new Lugar(0, 0, $tipo, $nombre, $dir, $web, $lat, $lon);
        $lugar->insertLugar();
    }

    function updatePlace($lugar){
        $lugar->update();
    }

    function deletePlace($id){
        $lugar = new Lugar($id, 0, "","","","","","");
        $lugar->delete();
    }


    function poblarAtletaPorD($did, $sid){
        $lista = new deportistas();
        $lista->poblarPorDisciplina($did, $sid);

        $largo = $lista->largo();
        for ($i=1; $i<=$largo; $i++){
            echo "<tr>";
            echo "<td>".$lista->getValor($i)->GetId_Persona()."</td>";
            echo "<td>".$lista->getValor($i)->GetPrimer_Nombre()." ".$lista->getValor($i)->GetPrimer_Apellido()."</td>";
            echo "<td><button type='button' class='btn btn-success btn-xs' value='".$lista->getValor($i)->GetId_Persona()."' onclick='checkAgenda(this.value)'>Seleccionar&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-arrow-right'></span></button></td>";
            echo "</tr>";
        }
    }

    function insertActividad($idpersona, $idlugar, $actividad, $observaciones, $date, $time){

        $agenda =new Agenda ($Id_Agenda, $idlugar, $idpersona, $date, $time, $actividad, $observaciones);
        $agenda->insertar();
        header("Location: ../cpanel/veragenda.php?q=addSuccess&id=".$idpersona);
    
    }


    function a(){

    }

    //////////////////////////////////////////////////////
    //      CONTROL PARA SABER QUÉ FUNCIÓN LLAMAR       //
    //////////////////////////////////////////////////////

    if(isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case "addTournament":
                addTournament($_REQUEST['yearpicker'], $_REQUEST['tournyName']);
                break;
            case "updateTourny":
                updateTourny($_REQUEST['tournyId'], $_REQUEST['tournyName'], $_REQUEST['tournyYear']);
                break;
            case "deleteTourny":
                deleteTourny($_REQUEST['id']);
                break;
            case "fillCommittees":
                fillCommittees($_REQUEST['id']);
                break;
            case "addCom":
                addCommittee($_REQUEST['tournyId'], $_REQUEST['comName']);
                break;
            case "deleteCom":
                deleteCommittee($_REQUEST['id']);
                break;
            case "modCom":
                updateCommittee($_REQUEST['id'], $_REQUEST['tournyId'], $_REQUEST['comName']);
                break;
            case "fillCategory":
                fillCategoriesDropdown($_REQUEST['id']);
                break;
            case "fillAthletes":
                fillAthletes($_REQUEST['tid'], $_REQUEST['cid']);
                break;
            case "fillAthletes01":
                fillAthletes01($_REQUEST['tid'], $_REQUEST['cid']);
                break;
            case "fillHistoricAthletes":
                fillHistoricAthletes($_REQUEST['tid'], $_REQUEST['cid']);
                break;
            case "fillHistoricCommittes":
                fillHistoricCommittes($_REQUEST['tid']);
                break;
            case "FillReglamento":
                FillReglamento($_REQUEST['id']);
                break;
            case "fillParticipantes":
                fillParticipantes($_REQUEST['pais'],$_REQUEST['sexo']);
                break;
            case "modMembers":
                modMembers($_REQUEST['iddelegacion'],$_REQUEST['atletas']);
                break;
            case "addTeam":
                addTeam($_REQUEST['tournyId'], $_REQUEST['categoryName'], $_REQUEST['teamName']);
                break;
            case "modTeam":
                updateTeam($_REQUEST['id'], $_REQUEST['tournyId'], $_REQUEST['categoryName'], $_REQUEST['teamName']);
                break;
            case "deleteTeam":
                deleteTeam($_REQUEST['id']);
                break;
            case "addPlace":
                addPlace($_REQUEST['name'], $_REQUEST['address'], $_REQUEST['web'], $_REQUEST['lat'], $_REQUEST['lon'], $_REQUEST['type']);
                break;
            case "updatePlace":
                $lugar = new Lugar($_REQUEST['id'], 0, $_REQUEST['type'], $_REQUEST['name'], $_REQUEST['address'], $_REQUEST['web'], $_REQUEST['lat'], $_REQUEST['lon']);
                updatePlace($lugar);
                break;
            case "deletePlace":
                deletePlace($_REQUEST['id']);
                break;
            case "poblarAtletaPorDel":
                poblarAtletaPorDel($_REQUEST['id']);
                break;
            case "poblarAtletaPorD":
                poblarAtletaPorD($_REQUEST['did'], $_REQUEST['sid']);
                break;
            case "insertActividad":
                insertActividad($_REQUEST['idpersona'], $_REQUEST['idlugar'], $_REQUEST['actividad'], $_REQUEST['observaciones'], $_REQUEST['date'], $_REQUEST['time']);
                break;
                
        }
    }

?>
