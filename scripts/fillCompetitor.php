<?php
    //session_start();
    include_once('includes/Participantes.php');
    include_once('includes/Deportistas.php');
    include_once('includes/Personal.php');

    include_once('dbcfg.php');

    $participantes = new participantes();
    $participantes->poblar();



    function fillCompetitors() {
        $participantes = new participantes();
        $participantes->poblar();

        echo "<select class='form-control' id='pais'>";
        echo "<option selected='selected'>Seleccionar una disciplina</option>";
        for ($i = 1; $i < $participantes->largo(); $i++){
            echo "<option value='".$participantes->getValor($i)->GetId_Persona()."'>".$participantes->getValor($i)->GetPrimer_Apellido()."</option>";
        }
        echo "</select>";
    }

    function getCompetitorsTable(){
        $participantes = new participantes();
        $participantes->poblar();

        for ($i = 1; $i < $participantes->largo(); $i++){
            $dbusername = "infoSelect";
            $dbpass = "infoselectpass";
            $connection = new mysqli(DBSERV, $dbusername, $dbpass);
            mysqli_select_db($connection, DBNAME);

            $sql = "SELECT d.idpersona FROM persona per, participante par, deportista d  WHERE 
                    d.idpersona=par.idpersona
                    AND par.idpersona=per.idpersona
                    AND d.idpersona = ".$participantes->getValor($i)->GetId_Persona()."";

            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
            if(mysqli_num_rows($result)==0){
            $Tipo="Personal";
            }else{
            $Tipo="Deportista";
            }

            echo "<tr>";
            echo "<td>".$participantes->getValor($i)->GetId_Persona()."</td>";
            $CompetitorName = utf8_encode($participantes->getValor($i)->GetPrimer_Nombre());
            $CompetitorSurname = utf8_encode($participantes->getValor($i)->GetPrimer_Apellido());
            $CompetitorCountry = utf8_encode($participantes->getValor($i)->GetNacionalidad());
            echo "<td>".$CompetitorSurname."</td>";
            echo "<td>".$CompetitorName."</td>";
            echo "<td>".$CompetitorCountry."</td>";
            echo "<td>".$Tipo."</td>";
            $cname = urlencode($participantes->getValor($i)->GetPrimer_Nombre());
            $csurname = urlencode($participantes->getValor($i)->GetPrimer_Apellido());
            $uri = "modcompetitor.php?cid=".$participantes->getValor($i)->GetId_Persona()."&csurname=".$csurname."&cname=".$cname."";
            $uri2 = "user-competitor.php?cid=".$participantes->getValor($i)->GetId_Persona()."&csurname=".$csurname."&cname=".$cname."";
            //$uri = "modcompetitor.php?cid=".$row['idpersona']."&csurname=".$csurname."&cname=".$cname."";
            $catUri = "showcompetitor.php?cid=".$participantes->getValor($i)->GetId_Persona()."&csurname=".$csurname."&cname=".$cname."&type=".$Tipo."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteCompetitor(".$participantes->getValor($i)->GetId_Persona().",&apos;".$Tipo."&apos;)'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "<td><button type='button' class='btn btn-success btn-xs' onclick='location.href=\"".$catUri."\"'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspVer Datos</button></td>";
           
            $sql2 =" SELECT nombreusuario FROM persona where idpersona=".$participantes->getValor($i)->GetId_Persona()."";
            $result2 = mysqli_query($connection, $sql2);
            $row2 = $result2->fetch_assoc();
            if($row2['nombreusuario']==''){
                echo "<td><button type='button' class='btn btn-warning btn-xs' onclick='location.href=\"".$uri2."\"'><span class='glyphicon glyphicon-user'></span>&nbsp&nbsp&nbspIngresar como Usuario</button></td>";
            }else{
                echo "<td><button type='button' class='btn btn-secondary btn-xs' onclick='location.href=\"".$uri2."\"' disabled><span class='glyphicon glyphicon-user'></span>&nbsp&nbsp&nbspUsuario Registrado</button></td>";
            }
            echo "</tr>";
            
        }
        $connection->close();
    }

    function CompletaPaises($nombrepais){

        
        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        $connection->set_charset("utf8");
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
        if ($nombrepais==NULL){
            
            while ($row = $result->fetch_assoc()) {
            echo "<option id='countrypick' value='".$row['idpais']."'>".$row['nombrepais']."</option>";

            }
            echo "</select>";
        }else{
            while ($row = $result->fetch_assoc()) {
            echo "<option id='countrypick' value='".$row['idpais']."'>".$row['nombrepais']."</option>";
            }
            echo "<option selected value='".$nombrepais."'>".$nombrepais."</option>";
            echo "</select>";
        }
    }

    function ShowCompetitor($id,$tipo){

        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";
        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        $connection->set_charset("utf8");
        mysqli_select_db($connection, DBNAME);
        if($tipo=='Deportista'){
            $sql = "SELECT NombrePersona, ApellidoPersona, sexo, NombrePais, AlturaDeportista, PesoDeportista 
            FROM Persona P, Participante Pa, Deportista D, Pais C 
            WHERE P.IdPersona = Pa.IdPersona AND Pa.IdPersona = D.IdPersona AND Pa.IdPais = C.IdPais 
            AND D.IdPersona = $id";

            $result = mysqli_query($connection, $sql);

            if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
            }

            while ($row = $result->fetch_assoc()){
                $Sexo=ucwords($row['sexo']);
                echo "<div class='col-md-4'>";
                echo "<div class='form-group'>
                        <label for='CompetitorName' class='form-label'>Nombre:</label>
                        <input type='text' name='CompetitorName' id='CompetitorName' class='form-control' value='".$row['NombrePersona']."' disabled>
                        </div>";
                echo "<div class='form-group'>
                        <label for='CompetitorSurname' class='form-label'>Apellido:</label>
                        <input type='text' name='CompetitorSurname' id='CompetitorSurname' class='form-control' value='".$row['ApellidoPersona']."' disabled>
                        </div>";
                echo "<div class='form-group'>
                    <label for='Sex' class='form-label'>Sexo:</label>
                    <input type='text' name='Sex' id='Sex' class='form-control' value='".$Sexo."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='Pais' class='form-label'>Pa&iacute;s de origen:</label>
                    <input type='text' name='Pais' id='Pais' class='form-control' value='".$row['NombrePais']."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='high' class='form-label'>Altura del Deportista en cm:</label>
                    <input type='text' name='high' id='high' class='form-control' value='".$row['AlturaDeportista']."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='Weight' class='form-label'>Peso del Deportista en Kg:</label>
                    <input type='text' name='Weight' id='Weight' class='form-control' value='".$row['PesoDeportista']."' disabled>
                    </div>";
                echo "</div>";
                $connection->close();   
            }
        }
        else{
            $sql = "SELECT P.NombrePersona, P.ApellidoPersona, P.Sexo, NombrePais, TipoPersonal
            FROM Persona P, Participante Pa, Personal Pe, Pais C 
            WHERE P.IdPersona = Pa.IdPersona AND Pa.IdPersona = Pe.IdPersona AND Pa.IdPais = C.IdPais 
            AND Pe.IdPersona = $id";

            $result = mysqli_query($connection, $sql);

            if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
            }

            while ($row = $result->fetch_assoc()){
                $Sexo=ucwords($row['Sexo']);
                echo "<div class='col-md-4'>";
                echo "<div class='form-group'>
                    <label for='CompetitorName' class='form-label'>Nombre:</label>
                    <input type='text' name='CompetitorName' id='CompetitorName' class='form-control' value='".$row['NombrePersona']."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='CompetitorSurname' class='form-label'>Apellido:</label>
                    <input type='text' name='CompetitorSurname' id='CompetitorSurname' class='form-control' value='".$row['ApellidoPersona']."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='Sex' class='form-label'>Sexo:</label>
                    <input type='text' name='Sex' id='Sex' class='form-control' value='".$Sexo."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='Pais' class='form-label'>Pa&iacute;s de origen:</label>
                    <input type='text' name='Pais' id='Pais' class='form-control' value='".$row['NombrePais']."' disabled>
                    </div>";
                echo "<div class='form-group'>
                    <label for='TipoPersonal' class='form-label'>Tipo de Personal:</label>
                    <input type='text' name='TipoPersonal' id='TipoPersonal' class='form-control' value='".$row['TipoPersonal']."' disabled>
                    </div>";
                echo "</div>";
                $connection->close();   
            }
        }
    }

    function InsertCompetitor($NombreParticipante, $ApellidoParticipante, $Sexo1, $Pais, $TipoParticipante, $Altura, $Peso, $TipoPersonal)
    {
      
        $Sexo=strtolower($Sexo1);

        if ($TipoParticipante == 'Personal'){

            $personal = new personal(0,$NombreParticipante,$ApellidoParticipante,$Sexo,'','','',$Pais,'',$TipoPersonal);
            $personal->impactar();
            header("Location: ../cpanel/competitor.php?q=added");

        }else{

            $Deportistas = new Deportistas();
            $Deportista = new Deportista(0,$NombreParticipante,$ApellidoParticipante,$Sexo,'','','',$Pais,'',$Peso,$Altura);
            $Deportistas->insertar($Deportista);
            $Deportistas->impactar();
            header("Location: ../cpanel/competitor.php?q=added");
        }

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
    function UpdateCompetitor($id){

        $dbuser = "toUpdate";
        $dbpass = "toUpdate";
        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");

        
        $sql1 = "SELECT idpersona FROM deportista WHERE idpersona=$id";//Se busca al participante en la tabla deportista
        $result1 = mysqli_query($connection, $sql1);

        if (!$result1) {
            printf("Error1: %s\n", mysqli_error($connection));
            exit();
        }
        if(mysqli_num_rows($result1)==0){ /*Si el participante no es deportista, el value de tipo es Personal.*/
            $sql2="SELECT nombrepersona, apellidopersona, sexo, nombrepais, tipopersonal
            FROM persona p, participante pa, personal per, pais c
            WHERE p.idpersona = pa.IdPersona
            AND pa.idpersona = per.IdPersona
            AND pa.idpais = c.IdPais
            AND per.idpersona=$id";
            $result2 = mysqli_query($connection, $sql2);
            if (!$result2) {
                printf("Error2: %s\n", mysqli_error($connection));
                exit();
            }
            while ($row = $result2->fetch_assoc()){
                echo "<h1 class='page-header'>&nbsp&nbsp&nbspModificando Participante Nº<kbd>".utf8_encode($id).", ".$row['nombrepersona']." ".utf8_encode($row['apellidopersona'])." </kbd></h1>";
                echo "<form action='../scripts/fillCompetitor.php?q=updatedcompetitor' method='post' enctype='multipart/form-data' role='form'>";
                echo "<div class='form-group'>
                    <input type='hidden' name='IdCompetitor' id='IdCompetitor' value='".$id."'>
                    </div>";
                echo "<div class='form-group'>
                        <label for='CompetitorName' class='form-label'>Nombre del Participante:</label>
                        <input type='text' name='CompetitorName' id='CompetitorName' class='form-control' value='".$row['nombrepersona']."' required oninvalid='this.setCustomValidity('Campo de Nombre Vacío')' oninput='setCustomValidity('')'>
                        </div>";
                echo "<div class='form-group'>
                        <label for='CompetitorSurname' class='form-label'>Apellido del Participante:</label>
                        <input type='text' name='CompetitorSurname' id='CompetitorSurname' class='form-control' value='".$row['apellidopersona']."' required oninvalid='this.setCustomValidity('Campo de Apellido Vacío')' oninput='setCustomValidity('')'>
                        </div>";
                echo "<div class='form-group'>
                        <label for='sexo' class='form-label'>Sexo</label>
                        <select class='form-control' name='sexo' id='sexo'>";
                        switch($row['sexo']){
                            case 'mujer':
                            echo "<option value='mujer' selected>Mujer</option>
                                <option value='hombre'>Hombre</option>";
                                break;
                            case 'hombre':
                            echo" <option value='mujer'>Mujer</option>
                                <option value='hombre' selected>Hombre</option>";
                                break;
                        }
                echo "</select>
                        </div>";
                echo "<div class='form-group'>
                      <label for='Pais' class='form-label'>Pa&iacute;</label>";
                echo "<select class='form-control' name='pais' id='pais' onchange='fillCountries(this.value)'>";
                        CompletaPaises($row['nombrepais']); 
                echo "</div>";
                echo "<div class='form-group'>
                        <label for='Pais' class='form-label'>Tipo de Participante</label>
                            <select class='form-control' name='tipo' id='tipo'>
                                <option id='TipoDeportista'>Deportista</option>
                                <option name='TipoDeportista' id='TipoPersonal' selected>Personal</option>
                            </select>  
                        </div>";
                echo "<div id='Personal' class='form-group'>
                        <label for='personal' class='form-label'>Tipo de Personal</label>
                        <select class='form-control' name='personal' id='personal'>";
                            switch($row['tipopersonal']){
                                case 'medico':
                                echo "<option value='medico' selected>M&eacute;dico</option>
                                    <option value='cocinero'>Cocinero</option>
                                    <option value='tecnico'>T&eacute;cnico</option>
                                    <option value='entrenador'>Entrenador</option>
                                    <option value='otro'>Otro</option>";
                                break;
                                case 'cocinero':
                                echo "<option value='medico'>M&eacute;dico</option>
                                    <option value='cocinero' selected>Cocinero</option>
                                    <option value='tecnico'>T&eacute;cnico</option>
                                    <option value='entrenador'>Entrenador</option>
                                    <option value='otro'>Otro</option>";
                                break;
                                case 'tecnico':
                                echo "<option value='medico'>M&eacute;dico</option>
                                    <option value='cocinero'>Cocinero</option>
                                    <option value='tecnico' selected>T&eacute;cnico</option>
                                    <option value='entrenador'>Entrenador</option>
                                    <option value='otro'>Otro</option>";
                                break;
                                case 'entrenador':
                                echo "<option value='medico'>M&eacute;dico</option>
                                    <option value='cocinero'>Cocinero</option>
                                    <option value='tecnico'>T&eacute;cnico</option>
                                    <option value='entrenador' selected>Entrenador</option>
                                    <option value='otro'>Otro</option>";
                                break;
                                case 'otro':
                                echo "<option value='medico'>M&eacute;dico</option>
                                    <option value='cocinero'>Cocinero</option>
                                    <option value='tecnico'>T&eacute;cnico</option>
                                    <option value='entrenador'>Entrenador</option>
                                    <option value='otro' selected>Otro</option>";
                                break;
                                }             
                echo "</select>
                        </div>";  
                echo "<div id='Deportista' class='form-group'>
                            <label for='Deportista' class='form-label'>Altura:</label>
                            <select name='alturapicker' id='alturapicker'></select>
                            <label for='Deportista' class='form-label'>cms.</label>
                        </br></br>
                            <label for='Deportista' class='form-label'>Peso:</label>
                            <select name='pesopicker' id='pesopicker'></select>
                            <label for='Deportista' class='form-label'>kgs.</label>
                        </div>";
                echo "<div class='form-group'>
                        <input type='submit' class='btn btn-success btn-md' value='Modificar Participante' name='submit'>
                        </div>";
                echo "</form>";
            }        
        }
        else{/*Si la consulta no es vacia ,  se trata de un deportista.*/
            $sql2="SELECT nombrepersona, apellidopersona, sexo, nombrepais, alturadeportista, pesodeportista
           FROM persona p, participante pa, deportista d, pais c
           WHERE p.idpersona = pa.IdPersona
           AND pa.idpersona = d.IdPersona
           AND pa.idpais = c.IdPais
           AND d.idpersona=$id";

           $result2 = mysqli_query($connection, $sql2);
            if (!$result2) {
                printf("Error3: %s\n", mysqli_error($connection));
                exit();
            }
            while ($row = $result2->fetch_assoc()){
                echo "<h1 class='page-header'>&nbsp&nbsp&nbspModificando Participante Nº<kbd>".utf8_encode($id).", ".$row['nombrepersona']." ".utf8_encode($row['apellidopersona'])." </kbd></h1>";
                echo "<form action='../scripts/fillCompetitor.php?q=updatedcompetitor' method='post' enctype='multipart/form-data' role='form'>";
                echo "<div class='form-group'>
                    <input type='hidden' name='IdCompetitor' id='IdCompetitor' value='".$id."'>
                    </div>";
                echo "<div class='form-group'>
                        <label for='CompetitorName' class='form-label'>Nombre del Participante:</label>
                        <input type='text' name='CompetitorName' id='CompetitorName' class='form-control' value='".$row['nombrepersona']."' required oninvalid='this.setCustomValidity('Campo de Nombre Vacío')' oninput='setCustomValidity('')'>
                        </div>";
                echo "<div class='form-group'>
                        <label for='CompetitorSurname' class='form-label'>Apellido del Participante:</label>
                        <input type='text' name='CompetitorSurname' id='CompetitorSurname' class='form-control' value='".$row['apellidopersona']."' required oninvalid='this.setCustomValidity('Campo de Apellido Vacío')' oninput='setCustomValidity('')'>
                        </div>";
                echo "<div class='form-group'>
                        <label for='sexo' class='form-label'>Sexo</label>
                        <select class='form-control' name='sexo' id='sexo' selected='".$row['sexo']."'>
                            <option value='mujer'>Mujer</option>
                            <option value='hombre'>Hombre</option>
                            </select>
                        </div>";
                echo "<div class='form-group'>
                        <label for='Pais' class='form-label'>Pa&iacute;s</label>";
                echo "<select class='form-control' name='pais' id='pais' onchange='fillCountries(this.value)'>";
                        CompletaPaises($row['nombrepais']);
                echo "</div>";
                echo "<div class='form-group'>
                        <label for='Pais' class='form-label'>Tipo de Participante</label>
                            <select class='form-control' name='tipo' id='tipo'>
                                <option id='TipoDeportista' selected>Deportista</option>
                                <option id='TipoPersonal'>Personal</option>
                            </select>  
                        </div>";
                echo "<div id='Personal' class='form-group'>
                        <label for='personal' class='form-label'>Tipo de Personal</label>
                                <select class='form-control' name='personal' id='personal'>
                                    <option value='medico'>M&eacute;dico</option>
                                    <option value='cocinero'>Cocinero</option>
                                    <option value='tecnico'>T&eacute;cnico</option>
                                    <option value='entrenador'>Entrenador</option>
                                    <option value='otro'>Otro</option>
                                </select>
                        </div>";  
                echo "<div id='Deportista' class='form-group'>
                            <label for='Deportista' class='form-label'>Altura:</label>
                            <select name='alturapicker' id='alturapicker'>
                            <option selected value=".$row['alturadeportista'].">".$row['alturadeportista']."</option>
                            </select>
                            <label for='Deportista' class='form-label'>cms.</label>
                        </br></br>
                            <label for='Deportista' class='form-label'>Peso:</label>
                            <select name='pesopicker' id='pesopicker'>
                            <option selected value=".$row['pesodeportista'].">".$row['pesodeportista']."</option>
                            </select>
                            <label for='Deportista' class='form-label'>kgs.</label>
                        </div>";
                echo "<div class='form-group'>
                        <input type='submit' class='btn btn-success btn-md' value='Modificar Participante' name='submit'>
                        </div>";
                echo "</form>";
            }        


        }    
    }

    function ModCompetitor($Cid, $CName, $CSurname, $sex, $country, $CType, $highpicker, $weightpicker, $type){

        $dbuser = "toUpdate";
        $dbpass = "toUpdate";
        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");
        $Sexo=strtolower($sex);

        $sql1="SELECT idpersona FROM personal WHERE idpersona=$Cid";
        $result1=mysqli_query($connection, $sql1);

        if (!$result1) {
            printf("Error4: %s\n", mysqli_error($connection));
            exit();
        }


        if ($CType == 'Personal' && mysqli_num_rows($result1)!=0){/*Si el participante sera personal y ademas existe en la tabla personal*/
            
            $personal = new personal($Cid,$CName,$CSurname,$Sexo,'','','',$country,'',$type);
            $personal->update();
            header("Location: ../cpanel/competitor.php?q=updated");
        }
        elseif($CType == 'Personal' && mysqli_num_rows($result1)==0){/*Si el participante sera personal y pero actualmente es deportista*/
            $sql2="DELETE FROM deportista where idpersona=$Cid";
            $result2=mysqli_query($connection, $sql2);
            if (!$result2) {
                printf("Error5: %s\n", mysqli_error($connection));
                exit();
            } 
            $sql3="INSERT into personal values($Cid,$type)";
            $result3=mysqli_query($connection, $sql3);
            if (!$result3) {
                printf("Error6: %s\n", mysqli_error($connection));
                exit();
            }
            
            $personal = new personal($Cid,$CName,$CSurname,$Sexo,'','','',$country,'',$type);
            $personal->update();
            header("Location: ../cpanel/competitor.php?q=updated");
        }
        elseif($CType == 'Deportista' && mysqli_num_rows($result1)==0){/*Si el participante sera deportista y ademas existe en la tabla deportista*/
            
            
            $Deportistas = new Deportistas();
            $Deportista = new Deportista($Cid,$CName,$CSurname,$Sexo,'','','',$country,'',$weightpicker,$highpicker);
            $Deportistas->insertar($Deportista);
            $Deportistas->update();
            header("Location: ../cpanel/competitor.php?q=updated");
        }
        elseif($CType == 'Deportista' && mysqli_num_rows($result1)!=0){/*Si el participante sera deportista y pero existe en la tabla personal*/
            $sql2="Delete from personal where idpersona=$Cid";
            $result2=mysqli_query($connection, $sql2);
            if (!$result2) {
                printf("Error7: %s\n", mysqli_error($connection));
                exit();
            } 
            $sql3="Insert into deportista values($Cid,$highpicker, $weightpicker)";
            $result3=mysqli_query($connection, $sql3);
            if (!$result3) {
                printf("Error8: %s\n", mysqli_error($connection));
                exit();
            }
            
            $Deportistas = new Deportistas();
            $Deportista = new Deportista($Cid,$CName,$CSurname,$sex,'','','',$country,'',$weightpicker,$highpicker);
            $Deportistas->insertar($Deportista);
            $Deportistas->update();
            header("Location: ../cpanel/competitor.php?q=updated");
        }
        $connection->close();
    }    

    ////////////////////////////////////////////////////////////////////////////
    // De acá para abajo se manejan los casos en los que se llama el archivo. //
    ////////////////////////////////////////////////////////////////////////////

    
    if(isset($_REQUEST['sexo'])){
        $Sexo=$_REQUEST['sexo'];
    }
    if(isset($_REQUEST['CompetitorName'])){
        $CompetitorName=$_REQUEST['CompetitorName'];
    }
    if(isset($_REQUEST['CompetitorSurname'])){
        $CompetitorSurname=$_REQUEST['CompetitorSurname'];
    }
    if(isset($_REQUEST['pais'])){
        $pais=$_REQUEST['pais'];
    }
    if(isset($_REQUEST['tipo'])){
        $CompetitorType=$_REQUEST['tipo'];
    }
    if(isset($_REQUEST['alturapicker'])){
        $alturapicker=$_REQUEST['alturapicker'];
    }
     if(isset($_REQUEST['pesopicker'])){
        $pesopicker=$_REQUEST['pesopicker'];
    }
     if(isset($_REQUEST['personal'])){
        $tipo=$_REQUEST['personal'];
    }

    if (isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case 'addcompetitor':
            InsertCompetitor($CompetitorName, $CompetitorSurname, $Sexo, $pais, $CompetitorType, $alturapicker, $pesopicker, $tipo);
            break;
            case 'updatedcompetitor':
            ModCompetitor($_REQUEST['IdCompetitor'], $CompetitorName, $CompetitorSurname, $Sexo, $pais, $CompetitorType, $alturapicker, $pesopicker, $tipo);
            break;
            case 'deletecompetitor':
            DeleteCompetitor($_REQUEST['id'], $_REQUEST['tipo']);
                break;
        }
    }   

?>
