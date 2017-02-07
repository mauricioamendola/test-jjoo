<?php
    include_once('includes/Equipos.php');
    include_once('includes/participantes.php');
    
    include_once('dbcfg.php');

    function fillTeam() {
        $equipos = new equipos();
        $equipos->poblar();

        echo "<select class='form-control' id='pais'>";
        echo "<option selected='selected'>Seleccionar una disciplina</option>";
        for ($i = 1; $i < $equipos->largo(); $i++){
            echo "<option value='".$equipos->getValor($i)->GetId_Persona()."'>".$participantes->getValor($i)->GetPrimer_Apellido()."</option>";
        }
        echo "</select>";
    }

    function getTeamsTable(){

        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $sql = "SELECT e.idequipo, e.nombreequipo, CONCAT(nombrecategoria,'(',nombredisciplina,')') as catdisc, nombredelegacion, CONCAT('(',fechatorneo,')',nombretorneo) as torneo
                    FROM torneo t, delegacion dl, participante p, deportista d, conforma cf, equipo e, categoria cat, disciplina di, integra2 i
                    WHERE dl.idtorneo = t.idtorneo
                    AND i.iddelegacion = dl.iddelegacion
                    AND i.idpersona = p.idpersona
                    AND d.idpersona = p.idpersona
                    AND cf.idpersona = p.idpersona
                    AND cf.idequipo = e.idequipo
                    AND cat.iddisciplina = di.iddisciplina
                    AND e.idcategoria = cat.idcategoria
                    GROUP BY idequipo
                    ORDER BY torneo DESC, nombredelegacion";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }



        while ($row = $result->fetch_assoc()){

            echo "<tr>";
            echo "<td>".$row['idequipo']."</td>";
            $TeamName = utf8_encode($row['nombreequipo']);
            $TeamCategory = utf8_encode($row['catdisc']);
            $TeamDelegation = utf8_encode($row['nombredelegacion']);
            $TeamTournament = utf8_encode($row['torneo']);
            echo "<td>".$TeamName."</td>";
            echo "<td>".$TeamCategory."</td>";
            echo "<td>".$TeamDelegation."</td>";
            echo "<td>".$TeamTournament ."</td>";
            $tname = urlencode($row['nombreequipo']);
            $tdelegation = urlencode($row['nombredelegacion']);
            $uri = "modTeam.php?id=".$row['idequipo']."&name=".$tname."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteTeam(".$row['idequipo'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "</tr>";     
        }
        $connection->close();
    }

    function CompletaPaises(){

        
        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT idpais, nombrepais FROM pais ORDER BY nombrepais";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        echo "<select class='form-control' name='pais' id='pais' onchange='fillCountries(this.value)'";
        echo "<option selected='selected'></option>";

        while ($row = $result->fetch_assoc()) {
            echo "<option id='countrypick' value='".$row['idpais']."'>".$row['nombrepais']."</option>";
        }

        echo "</select>";
    }

    function DeleteCompetitor($idparticipante, $tipoparticipante){

        if ($tipoparticipante == 'Deportista'){
            $deportistas = new Deportistas();
            $deportista = new Deportista($idparticipante,'','','','','','','','','');
            $deportistas->insertar($deportista);
            $deportistas->delete();
        }else{
            $personal = new personal($idparticipante,'','','','','','','','');
            $personal->delete();
        }


    }

    function fillDelegations($idtorneo,$idDel){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdDelegacion, NombreDelegacion FROM delegacion d, torneo t 
            WHERE d.Idtorneo=$idtorneo  
            AND d.idtorneo=t.idtorneo
            Group by idDelegacion ORDER BY NombreDelegacion";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if($idDel==NULL){
            echo "<option value=0>Seleccione una Delegacion</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['IdDelegacion']."'>".$row['NombreDelegacion']."</option>";
            }
        }else{
            echo "<option value=0>Seleccione una Delegacion</option>";
            while ($row = $result->fetch_assoc()) {
                if($idDel==$row['IdDelegacion']){
                    echo "<option selected value='".$row['IdDelegacion']."'>".$row['NombreDelegacion']."</option>";
                }else{
                    echo "<option value='".$row['IdDelegacion']."'>".$row['NombreDelegacion']."</option>";
                }
            }

        }
        $connection->close();
    }

    function filltournaments($idtorneo){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdTorneo, FechaTorneo, NombreTorneo FROM torneo ORDER BY FechaTorneo DESC, NombreTorneo ASC";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if ($idtorneo==NULL){
            while ($row = $result->fetch_assoc()) {
                $torneo = urlencode($row['NombreTorneo']);
                echo "<option value='".$row['IdTorneo']."'>".$row['FechaTorneo']." - ".$row['NombreTorneo']."</option>";
            }
        }else{
            while ($row = $result->fetch_assoc()) {
                if($row['IdTorneo']==$idtorneo){
                   $torneo = urlencode($row['NombreTorneo']);
                    echo "<option selected value='".$row['IdTorneo']."'>".$row['FechaTorneo']." - ".$row['NombreTorneo']."</option>";
                }else{
                   $torneo = urlencode($row['NombreTorneo']);
                    echo "<option value='".$row['IdTorneo']."'>".$row['FechaTorneo']." - ".$row['NombreTorneo']."</option>"; 
                }
            }
        }
        $connection->close();
    }

    function fillCategory($id,$genero,$idcat){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else {

            if($genero == 'Masculino'){
            
                $sql = "SELECT IdCategoria, NombreCategoria FROM categoria c, disciplina d 
                WHERE c.IdDisciplina='$id'
                AND c.Iddisciplina = d.iddisciplina
                AND Genero = 'masculino'
                ORDER BY NombreCategoria";
            }
            elseif($genero == 'Femenino'){
            
                $sql = "SELECT IdCategoria, NombreCategoria FROM categoria c, disciplina d 
                WHERE c.IdDisciplina='$id'
                AND c.Iddisciplina = d.iddisciplina
                AND Genero = 'femenino'
                ORDER BY NombreCategoria";
            }

            elseif($genero == 'Mixto'){
            
            $sql = "SELECT IdCategoria, NombreCategoria, Genero FROM categoria c, disciplina d 
            WHERE c.IdDisciplina='$id'
            AND c.Iddisciplina = d.iddisciplina
            AND Genero = 'mixto'
            ORDER BY NombreCategoria";
            }

            $result = mysqli_query($connection, $sql);

            if (!$result) {
                    printf("Error: %s\n", mysqli_error($connection));
                    exit();
            }

            if($idcat==NULL){
                echo "<option value=0>Seleccione una Categor&iacute;a</option>";

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['IdCategoria']."'>".$row['NombreCategoria']."</option>";
                }

            }else{
                echo "<option value=0>Seleccione una Categor&iacute;a</option>";

                while ($row = $result->fetch_assoc()) {

                    if($idcat==$row['IdCategoria']){
                        echo "<option selected value='".$row['IdCategoria']."'>".$row['NombreCategoria']."</option>";
                    }else{
                        echo "<option value='".$row['IdCategoria']."'>".$row['NombreCategoria']."</option>";
                    }

                }

            }
        $connection->close(); 
        }   
    }

    function fillSports($idsport){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdDisciplina, NombreDisciplina FROM disciplina ORDER BY nombredisciplina";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if ($idsport==NULL){

            while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['IdDisciplina']."'>".$row['NombreDisciplina']."</option>";
            }
        }else{
            while ($row = $result->fetch_assoc()) {
                if($row['IdDisciplina']==$idsport){
                   echo "<option selected value='".$row['IdDisciplina']."'>".$row['NombreDisciplina']."</option>";
                }else{
                   echo "<option value='".$row['IdDisciplina']."'>".$row['NombreDisciplina']."</option>"; 
                }
            }
        }
        $connection->close();
    }

    function fillCompetitor($iddelegacion,$genero){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        $connection->set_charset("utf8");
        mysqli_select_db($connection, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else {
            if($genero == 'Masculino' ){
                $sql = "SELECT par.IdPersona, NombrePersona, ApellidoPersona, sexo FROM persona per, participante par, integra2 i, delegacion d
                WHERE i.Iddelegacion = '$iddelegacion'
                AND i.Iddelegacion = d.iddelegacion
                AND i.idpersona = par.idpersona
                AND par.idpersona = per.idpersona
                AND per.sexo = 'hombre' 
                ORDER BY ApellidoPersona DESC";
            }elseif($genero == 'Femenino' ){
                $sql = "SELECT par.IdPersona, NombrePersona, ApellidoPersona, sexo FROM persona per, participante par, integra2 i, delegacion d
                WHERE i.Iddelegacion='$iddelegacion' 
                AND i.Iddelegacion = d.iddelegacion
                AND i.idpersona = par.idpersona
                AND par.idpersona = per.idpersona
                AND per.sexo = 'mujer'
                ORDER BY ApellidoPersona DESC";
            }elseif($genero == 'Mixto' ){
                $sql = "SELECT par.IdPersona, NombrePersona, ApellidoPersona, sexo FROM persona per, participante par, integra2 i, delegacion d
                WHERE i.Iddelegacion='$iddelegacion' 
                AND i.Iddelegacion = d.iddelegacion
                AND i.idpersona = par.idpersona
                AND par.idpersona = per.idpersona
                ORDER BY ApellidoPersona DESC";      
            }

            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error1: %s\n", mysqli_error($connection));
                exit();
            }
        }

        while ($row = $result->fetch_assoc()) {
            $id=$row['IdPersona'];
            $sql2="SELECT d.IdPersona FROM deportista d WHERE d.idpersona=$id";
            $result2 = mysqli_query($connection, $sql2);

            if(mysqli_num_rows($result2)==0){
                echo "<option value='".$row['IdPersona']."'>".utf8_encode($row['NombrePersona'])." ".utf8_encode($row['ApellidoPersona'])."  [".utf8_encode($row['sexo'])."]->(Personal)</option>";
            }else{
                echo "<option value='".$row['IdPersona']."'>".utf8_encode($row['NombrePersona'])." ".utf8_encode($row['ApellidoPersona'])."  [".utf8_encode($row['sexo'])."]->(Deportista)</option>";  
            }
        }
        $connection->close();
    }



    function addTeam($delegacion1,$atletas1,$name,$category1)
    {

        $delegacion=json_decode($delegacion1);
        $atletas=json_decode($atletas1);/*es el array de participantes dentro del equipo*/
        $category=json_decode($category1);
           $participantes= new participantes();
        foreach($atletas as $participante){
            $participante1= new Participante($participante,'','','','','','','','');
            $participantes->insertar($participante1);
        }
        $equipo=new Equipo(0,$name,$participantes,$category);
        $equipo->impactar();
        header("Location: ../cpanel/teams.php?q=Teamadded");
        
    }

    function updateTeam($id, $name){

        $dbuser = "toUpdate";
        $dbpass = "toUpdate";
        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");

        $sql1 = "SELECT c.idpersona, CONCAT(nombrepersona,' ',apellidopersona) as Nompersona, p.sexo, di.iddisciplina, d.iddelegacion, d.idtorneo, nombreequipo, cat.idcategoria
        FROM persona p, participante pa, conforma c, integra2 i, delegacion d, equipo e, categoria cat, disciplina di, torneo t 
        WHERE p.idpersona=pa.IdPersona
        AND pa.idpersona=i.IdPersona
        AND pa.idpersona=c.IdPersona
        AND d.iddelegacion=i.idDelegacion
        AND c.idequipo=e.idequipo
        AND cat.idcategoria=e.idcategoria
        AND t.idtorneo=d.idtorneo
        AND di.iddisciplina=cat.iddisciplina
        AND c.idequipo=$id GROUP BY c.idequipo";
        $result1 = mysqli_query($connection, $sql1);

        if (!$result1) {
            printf("Error1: %s\n", mysqli_error($connection));
            exit();
        }

        $sql2 = "SELECT  p.sexo  
        FROM persona p, participante pa, conforma c 
        WHERE p.idpersona=pa.IdPersona
        AND pa.idpersona=c.IdPersona
        AND c.idequipo=$id";
        $result2 = mysqli_query($connection, $sql2);

        if (!$result2) {
            printf("Error1: %s\n", mysqli_error($connection));
            exit();
        }

        $mujer=0;
        $hombre=0;

        while ( $row2 = $result2->fetch_assoc() ){

            if ($row2['sexo'] == 'mujer'){
            $mujer=1;
            }elseif($row2['sexo'] == 'hombre'){
            $hombre=1;
            }
        }
            if($hombre==1 && $mujer==1){
            $genero='3';
            }elseif($hombre==1 && $mujer==0){
            $genero='1';
            }elseif($mujer==1 && $hombre==0){
            $genero='2';
            }





        while ( $row = $result1->fetch_assoc() ){

            $idcategoria=$row['idcategoria'];
            $iddelegacion=$row['iddelegacion'];

            echo "<button type='button' class='btn btn-primary btn-md pull-left' onclick='window.history.back();' value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>";
            echo "<h1 class='page-header'>&nbsp&nbsp&nbspModificando Equipo Nº<kbd>".$id.", ".$name."</kbd></h1>";

            echo "<form method='post' enctype='multipart/form-data' role='form'>";
            echo "<div class='form-group'>";
            echo "<div id='NameTeam' name='NameTeam' class='form-group'>";
            //Nombre del Equipo
            echo "<label for='TeamName' class='form-label'>Nombre del Equipo:</label>";
            echo "<input type='text' name='TeamName' id='TeamName' class='form-control' value='".$row['nombreequipo']."' required oninvalid='this.setCustomValidity('Campo de Nombre Vacío')' oninput='setCustomValidity('')>";

                    if(isset($_REQUEST['q']) and $_REQUEST['q']=='existeequipo'){

                                    echo "<div class='alert alert-danger alert-dismissible fade in role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                    </button>
                                    <strong>&nbsp&nbspNombre de Equipo ya existente</strong>
                                    </div>";    
                    }

            echo "</div>";
            //Genero del Equipo
            echo "<div id='genero' class='form-group'>";
            echo "<label for='Sexo' class='form-label'>Genero:</label>";
            echo "<select name='Sexo' id='Sexo' class='form-control' onchange=\"fillCompetitor1((document.getElementById('selectedDelegation').value,this.value))\">";
            echo "<option value=0>Seleccione una Genero</option>";
                if ($genero==1) {
                    echo "<option selected value='Masculino'>Masculino</option>";
                    echo "<option value='Femenino'>Femenino</option>";
                    echo "<option value='Mixto'>Mixto</option>";
                }elseif ($genero==2) {
                    echo "<option value='Masculino'>Masculino</option>";
                    echo "<option selected value='Femenino'>Femenino</option>";
                    echo "<option value='Mixto'>Mixto</option>";
                }elseif ($genero==3) {
                    echo "<option value='Masculino'>Masculino</option>";
                    echo "<option value='Femenino'>Femenino</option>";
                    echo "<option selected value='Mixto'>Mixto</option>";
                }
            echo "</select>";
            echo "</div>";
            //Disciplina
            echo "<div id='disciplina' class='form-group'>";
            echo "<label for='SportName' class='form-label'>Disciplina:</label>";
            echo "<select name='SportName' id='selectedSport' class='form-control' onchange=\"fillCategory(this.value,document.getElementById('Sexo').value,'')\">";             
                    fillSports($row['iddisciplina']);
            echo "</select>";
            echo "</div>";
            //Categoria
            echo "<div id='categoria' class='form-group'>";
            echo "<label for='categoryName' class='form-label'>Categor&iacute;a:</label>";
            echo "<select name='categoryName' id='selectedCategory' class='form-control'>";
            echo "</select>";
            echo "</div>";
            //Torneo
            echo "<div id='torneo' class='form-group'>";
            echo "<label for='tournyName' class='form-label'>Torneo:</label>";
            echo "<select name='tournyName' id='selectedTourny' class='form-control' onchange=\"fillDelegations(this.value)\">";
                    filltournaments($row['idtorneo']);    
            echo "</select>";
            echo "</div>";
        }
            //Delegacion
            echo "<div id='delegacion' class='form-group'>";
            echo "<label for='DelegationName' class='form-label'>Delegaci&oacute;n:</label>";
            echo "<select name='DelegationName' id='selectedDelegation' class='form-control' onchange=\"fillCompetitor1(this.value,document.getElementById('Sexo').value)\">";
            echo "</select>";
            echo "</div>";       
            echo "<br>";
            //Participantes del Equipo
            echo "<div id='final' class='form-group'>";
            echo "<div class='col-md-5'>";
            echo "<label for='SelectedCompetitor' class='form-label'>Participantes disponibles:</label>";
            echo "<select class='form-control' size='10' id='selectedCompetitor' name='selectedCompetitor'>";
            echo "</select>";
            echo "<p class='btn-lg btn-success  glyphicon glyphicon-arrow-right' onclick='readPreselections()''></p>";
            echo "<br><br>";
            echo "</div>";
            //Participantes Preseleccionados
            
            $sql3 = "SELECT par.IdPersona, NombrePersona, ApellidoPersona, sexo FROM persona per, participante par, conforma c
                WHERE par.idpersona = per.idpersona
                AND par.idpersona = c.idpersona
                AND c.idequipo = $id";

                $result3 = mysqli_query($connection, $sql3);

                if (!$result3) {
                    printf("Error1: %s\n", mysqli_error($connection));
                    exit();
                }
            echo "<div class='col-md-5'>";
            echo "<label for='preseleccionados' class='form-label'>Participantes Preseleccionados:</label>";
            echo "<select class='form-control' size='10' id='preseleccionados'>";
                
                while ( $row = $result3->fetch_assoc() ){
                    $id2=$row['IdPersona'];
                    $sql4="SELECT d.IdPersona FROM deportista d WHERE d.idpersona=$id2";
                    $result4 = mysqli_query($connection, $sql4);

                    if(mysqli_num_rows($result4)==0){
                        echo "<option value='".$row['IdPersona']."'>".$row['NombrePersona']." ".$row['ApellidoPersona']."  [".$row['sexo']."]->(Personal)</option>";
                        echo "<script> 
                        </script> ";
                    }else{
                        echo "<option value='".$row['IdPersona']."'>".$row['NombrePersona']." ".$row['ApellidoPersona']."  [".$row['sexo']."]->(Deportista)</option>"; 
                        echo "<script> 
                        </script> "; 
                    }
                }
            echo "</select>";
            echo "</div>";
            echo "<div class='col-md-5'>";
            echo "<p class='btn-lg btn-danger glyphicon glyphicon-arrow-left' onclick='removeTeam()'></p>";
            echo "</div>";
            echo "<br><br><br>";
            echo "<div class='form-group col-md-10' id='Final'>";
            echo "<br>";
            echo "<input type='hidden' name='idequipo' id='idequipo' value='".$id."'>";
            echo "<button type='button' class='btn btn-success btn-lg' value='Modificar Equipo' name='submit' onclick='readPreselections()'>Modificar Equipo</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</form>";
            echo "<script>

                window.onload = function() {
                 
                fillCategory(document.getElementById('selectedSport').value,document.getElementById('Sexo').value,".$idcategoria.");
                fillDelegations(document.getElementById('selectedTourny').value,".$iddelegacion.");
                fillCompetitor(".$iddelegacion.",document.getElementById('Sexo').value);
                
            }
            
            </script>";
    }

    function  modTeam($id,$delegacion1,$atletas1,$name,$category1){

        $delegacion=json_decode($delegacion1);
        $atletas=json_decode($atletas1);/*es el array de participantes dentro del equipo*/
        $category=json_decode($category1);
        $participantes= new participantes();

        foreach($atletas as $participante){
            $participante1= new Participante($participante,'','','','','','','','');
            $participantes->insertar($participante1);
        }
        $equipo=new Equipo($id,$name,$participantes,$category);
        $equipo->update();
        header("Location: ../cpanel/teams.php?q=Teamupdated");

    }

    function DeleteTeam($id){

        $equipo=new Equipo($id,'','','');
        $equipo->delete();
        header("Location: ../cpanel/teams.php?q=Teamdeleted");

    }


    ////////////////////////////////////////////////////////////////////////////
    // De acá para abajo se manejan los casos en los que se llama el archivo. //
    ////////////////////////////////////////////////////////////////////////////

    if (isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case 'search':
                fillTableSearch($_REQUEST['s']);
                break;
            case 'fillDelegations':
                fillDelegations($_REQUEST['id'],$_REQUEST['find']);
                break;
            case 'fillCategory':
                fillCategory($_REQUEST['id'],$_REQUEST['genero'],$_REQUEST['find']);
                break;
            case 'fillCompetitor':
                fillCompetitor($_REQUEST['id'],$_REQUEST['text']);
                break;
            case 'addTeam':
                addTeam($_REQUEST['delegation'],$_REQUEST['atletas'],$_REQUEST['name'],$_REQUEST['category']);
                break;
            case 'modTeam':
                modTeam($_REQUEST['idequipo'],$_REQUEST['delegation'],$_REQUEST['atletas'],$_REQUEST['name'],$_REQUEST['category']);
                break;
             case 'deleteteam':
                DeleteTeam($_REQUEST['id']);
                break;
        }
    }
    

?>
