<?php
    include_once "dbcfg.php";
    include_once "includes/eventos.php";
    include_once "includes/equipos.php";
    include_once "includes/resultados.php";

function fillPhasesdropdown($id, $idfase){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);
        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            
            $sql = "SELECT IdCompetencia, NombreCompetencia FROM Competencia WHERE idtorneo=$id ORDER BY NombreCompetencia";
            
            $result = $connection->query($sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }
        if($idfase==NULL){
            
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['IdCompetencia']."'>".$row['NombreCompetencia']."</option>";
            }
        }
        else{
            while ($row = $result->fetch_assoc()) {
                if($idfase==$row['IdCompetencia']){
                     echo "<option selected value='".$row['IdCompetencia']."'>".$row['NombreCompetencia']."</option>";
                }
                else{
                     echo "<option value='".$row['IdCompetencia']."'>".$row['NombreCompetencia']."</option>";
                }
            }
        }
        $connection->close();
}

function fillEventsTable(){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    } 
    else {
            
        $sql = "SELECT IdEvento, NombreEvento, CONCAT(NombreDisciplina,' [',NombreCategoria,'-',Genero,']') as Discat, CONCAT(NombreCompetencia,' [',NombreTorneo,'-',FechaTorneo,']') as FaseTorneo, NombreLugar, DATE(FechahoraEvento) as Fecha, TIME(FechahoraEvento) as Hora, EstadoEvento 
        FROM Competencia Comp, Evento Ev, Categoria cat, Disciplina d, Lugar L, torneo T
        WHERE Comp.IdTorneo = T.IdTorneo 
        AND Ev.IdCompetencia = Comp.IdCompetencia
        AND Ev.IdCategoria = cat.IdCategoria
        AND cat.IdDisciplina = d.IdDisciplina
        AND Ev.IdLugar = L.Idlugar
        ORDER BY Fecha, Hora";
            
        $result = $connection->query($sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
        }


        while ($row = $result->fetch_assoc()){

            $originalDate = $row['Fecha'];
            $newDate = date("d-m-Y", strtotime($originalDate));
            echo "<tr>";
            echo "<td>".$row['IdEvento']."</td>";
            echo "<td>".$row['NombreEvento']."</td>";
            echo "<td>".$row['FaseTorneo']."</td>";
            echo "<td>".$row['Discat']."</td>";
            echo "<td>".$newDate."</td>";
            echo "<td>".$row['Hora']."</td>";
            echo "<td>".$row['EstadoEvento']."</td>";
            $placename = urlencode($row['NombreLugar']);
            $eventname = urlencode($row['NombreEvento']);
            $uri = "modevent.php?id=".$row['IdEvento']."&name=".$eventname."";
            $uri1 = "ManageCompetitors.php?id=".$row['IdEvento']."&name=".$eventname."";
            $uri2 = "ManageScores.php?id=".$row['IdEvento']."&name=".$eventname."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteEvent(".$row['IdEvento'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "<td><button type='button' class='btn btn-success btn-xs' onclick='location.href=\"".$uri1."\"'><span class='fa fa-futbol-o'></span>&nbsp&nbsp&nbspGestionar Equipos</button></td>";
            if (($row['EstadoEvento'] == "suspendido") or ($row['EstadoEvento'] == "programado")){
                echo "<td><button type='button' class='btn btn-secondary btn-xs' disabled><span class='fa fa-trophy'></span>&nbsp&nbsp&nbspGestionar Resultados</button></td>";
                }
            else{
                echo "<td><button type='button' class='btn btn-warning btn-xs' onclick='location.href=\"".$uri2."\"'><span class='fa fa-trophy'></span>&nbsp&nbsp&nbspGestionar Resultados</button></td>";
                
            }
            echo "</tr>";     
        }
        $connection->close();
    }
}

function addEvent($nombre,$fase,$categoria,$fecha,$hora,$lugar,$estado){
        $fechahora = $fecha . ' ' . $hora;
       

        $eventos= new eventos();
        $evento= new Evento(0,$nombre,$categoria,$fechahora,$lugar,$estado,'');
        $eventos->insertar($evento);
        $eventos->impactar($fase);
        
        
        header("Location: ../cpanel/events.php?q=eventadded");
        
}

function modEvent($id,$nombre,$fase,$categoria,$fecha,$hora,$lugar,$estado){

        $fechahora = $fecha . ' ' . $hora;
       

        $eventos= new eventos();
        $evento= new Evento($id,$nombre,$categoria,$fechahora,$lugar,$estado,'');
        $eventos->insertar($evento);
        $eventos->actualizar($fase);
        
        
        header("Location: ../cpanel/events.php?q=eventupdated");
}

function DeleteEvent($id){
    
        $eventos= new eventos();
        $evento= new Evento($id,'','','','','','');
        $eventos->insertar($evento);
        $eventos->eliminar();
        
        
        header("Location: ../cpanel/events.php?q=eventdeleted");
        
}

function fillEventData($id){

    $dbuser = "toUpdate";
    $dbpass = "toUpdate";
    $connection = new mysqli(DBSERV, $dbuser, $dbpass);

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    $sql = "SELECT idevento, e.idcompetencia, c.idtorneo, idlugar, cat.iddisciplina, e.idcategoria, nombreevento, date(fechahoraevento) as fecha, time(fechahoraevento) as hora, EstadoEvento 
    FROM evento e, competencia c, categoria cat 
    WHERE idevento=$id 
    AND e.idcompetencia = c.idcompetencia
    AND e.idcategoria = cat.idcategoria";//Se busca al evento y sus caracteristicas
    $result = mysqli_query($connection, $sql);

    while ($row = $result->fetch_assoc()){
        include_once "../scripts/dataMgmt.php";

                echo "<h1 class='page-header'>&nbsp&nbsp&nbspModificando Evento Nº<kbd>".$id.", ".$row['nombreevento']."</kbd></h1>";
                echo "<form action='' method='post' enctype='multipart/form-data' role='form'>";
                echo "<div class='form-group'>
                    <input type='hidden' name='IdEvento' id='IdEvento' value='".$id."'>
                    </div>";
                echo "<div class='col-md-4'>
                        <label for='nombre'>Nombre del evento:</label>
                        <input type='text' name='nombre' id='editnombre' class='form-control' value='".$row['nombreevento']."'></input>
                        <br>";
                echo "<label for='torneo'>Torneo:</label>
                        <select name='torneo' class='form-control' id='selectedTourny' onchange='fillPhases()'' disabled>";
                                fillTournyDropdown($row['idtorneo']);           
                echo "</select>
                        <br>
                        <label for='PhaseName' class='form-label'>Fase a la que pertenecera el evento:</label>
                        <select class='form-control' name='PhaseName' id='PhaseList' disabled>"; 
                                fillPhasesdropdown($row['idtorneo'],$row['idcompetencia']);   
                echo "</select>
                        <br>
                        <label for='nombre'>Disciplina:</label>
                        <select name='disciplina' class='form-control' id='selectDisciplina' onchange='fillCategory()' disabled>"; 
                                fillSportsDropdown($row['iddisciplina']);
                echo "</select>
                        <br>
                        <label for='nombre'>Categoría:</label>
                        <select name='categoria' class='form-control' id='selectCategoria' disabled>";
                                fillCategoriesDropdown($row['iddisciplina'],$row['idcategoria']);
                echo "</select>
                        <br>
                        <label for='fecha' id='labelFecha'>Fecha:</label>
                        <input type='date' name='fecha' id='inputFecha' class='form-control' value=".$row['fecha']."></input>
                        <br>
                        <label for='hora' id='labelHora'>Hora:</label>
                        <input type='time' name='hora' id='inputHora' class='form-control' value=".$row['hora']."></input>
                        <br>
                        <label for='selectLugar'>Lugar:</label>
                        <select name='lugar' class='form-control' id='selectLugar'>";
                                fillPlacesdropdown($row['idlugar']);
                echo "</select>
                        <br>
                        <label for='nombre'>Estado:</label>
                        <br>
                        <select name='estado' id='selectEstado' class='form-control'>";
                        switch($row['EstadoEvento']){
                                case 'activo':
                            echo "<option value='activo' selected>Activo</option>
                                    <option value='finalizado'>Finalizado</option>
                                    <option value='programado'>Programado</option>
                                    <option value='suspendido'>Suspendido</option>";
                                break;
                                case 'finalizado':
                            echo "<option value='activo'>Activo</option>
                                    <option value='finalizado' selected>Finalizado</option>
                                    <option value='programado'>Programado</option>
                                    <option value='suspendido'>Suspendido</option>";
                                break;
                                case 'programado':
                            echo "<option value='activo'>Activo</option>
                                    <option value='finalizado'>Finalizado</option>
                                    <option value='programado' selected>Programado</option>
                                    <option value='suspendido'>Suspendido</option>";
                                break;
                                case 'suspendido':
                            echo "<option value='activo'>Activo</option>
                                    <option value='finalizado'>Finalizado</option>
                                    <option value='programado'>Programado</option>
                                    <option value='suspendido' selected>Suspendido</option>";
                                break;
                        }
                echo "</select>
                        <br><br><button id='update' type='button' class='btn btn-success' onclick='Update()'>Modificar evento</button>                     
                    </div>";
    }
}



function ManageEventCompetitors($id,$name){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql1 = "SELECT e.idcategoria, nombrecategoria, NombreEvento, nombredisciplina, c.idtorneo, CONCAT(UCASE(LEFT(cat.genero, 1)),SUBSTRING(cat.genero, 2)) as Genero FROM evento e, competencia c, categoria cat, disciplina d 
            WHERE e.idcompetencia = c.idcompetencia
            AND e.idcategoria = cat.idcategoria
            AND cat.iddisciplina = d.iddisciplina
            AND idevento = $id "; 

    $result1 = mysqli_query($connection, $sql1);

    while ($row = $result1->fetch_assoc()){
        echo "<button type='button' class='btn btn-primary btn-md pull-left' onclick='window.history.back();' value='Volver'><span class='glyphicon glyphicon-chevron-left'></span>&nbsp&nbspVolver</button>";
        echo "<h1 class='page-header'>&nbsp&nbsp&nbspGestion de Equipos participantes</h1>";
        echo "<h2 class='page-header'>&nbsp&nbsp&nbspEvento Nº<kbd>".$id.", ".$row['NombreEvento']." </kbd></h2>";
        echo "<form action='' method='post' enctype='multipart/form-data' role='form'>";
        echo "<div class='form-group'>
                <input type='hidden' name='IdEvento' id='IdEvento' value='".$id."'>
                <input type='hidden' name='IdTorneo' id='IdTorneo' value='".$row['idtorneo']."'>
                <input type='hidden' name='IdCategoria' id='IdCategoria' value='".$row['idcategoria']."'>
        </div>";
        echo "<div class='col-md-5'>";
            echo "<label for='SelectedCompetitor' class='form-label'>Equipos que practican ".$row['nombredisciplina']." [".$row['nombrecategoria']."(".$row['Genero'].")]:</label>";
            echo "<br><br>";
            echo "<select class='form-control' size='10' id='selectedCompetitor' name='selectedCompetitor'>";
            echo "</select>";
            echo "<p class='btn-lg btn-success glyphicon glyphicon-arrow-right' onclick='addTeam()'></p>";
            echo "<br><br>";
        echo "</div>";
    }
        echo "<div class='col-md-5'>";
            echo "<label for='preseleccionados' class='form-label'>Equipos Participantes del Evento:</label>";
            echo "<br><br>";
            echo "<select class='form-control' size='10' id='preseleccionados' name='preseleccionados'>";
            echo "</select>";
            echo "<p class='btn-lg btn-danger glyphicon glyphicon-arrow-left' onclick='removeTeam()'></p>";
            echo "<br><br>";
        echo "</div>";
            echo "<br><br><br>";
        echo "<div class='form-group col-md-10' id='Final'>";
            echo "<br>";
            echo "<button type='button' class='btn btn-success btn-lg' value='Gestion Equipos' name='submit' onclick='readPreselections()'>Finalizar Gestion de Equipos</button>";
        echo "</div>";
        echo "</form>";
    

    $connection->close();
           
}

function FillCompetitors($torneo,$categoria){


    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql = "SELECT e.idequipo, nombreequipo, nombredelegacion FROM equipo e, conforma c, participante par, integra2 i, delegacion d 
            WHERE e.idequipo = c.idequipo
            AND c.idpersona = par.idpersona
            AND par.idpersona = i.idpersona
            AND i.iddelegacion = d.iddelegacion
            AND e.idcategoria = $categoria
            AND d.idtorneo = $torneo";

    $result = mysqli_query($connection, $sql);

    while ($row = $result->fetch_assoc()){
        echo "<option value='".$row['idequipo']."'>".$row['nombreequipo']."[".$row['nombredelegacion']." ]</option>";
    }

    $connection->close();
}

function FillActiveCompetitors($idevento){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql = "SELECT comp.idequipo, nombreequipo, nombredelegacion 
    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d 
    WHERE comp.idequipo = e.idequipo
    AND e.idequipo = c.idequipo
    AND c.idpersona = par.idpersona
    AND par.idpersona = i.idpersona
    AND i.iddelegacion = d.iddelegacion
    AND comp.idevento = $idevento";

    $result = mysqli_query($connection, $sql);

    while ($row = $result->fetch_assoc()){
        echo "<option value='".$row['idequipo']."'>".$row['nombreequipo']."[".$row['nombredelegacion']." ]</option>";
    }

    $connection->close();
}

function UpdateCompetitors($idevento1,$equipos1){

$equipos=json_decode($equipos1);/*es el array de equipos participantes del evento*/
$idevento=json_decode($idevento1);  

$teams= new equipos();

        foreach($equipos as $participante){

            $equipo= new equipo($participante,'','','');
            $teams->insertar($equipo);

        }

        $eventos= new eventos();
        $evento = new Evento($idevento,'','','','','',$teams);

        $eventos->insertar($evento);
        $eventos->actualizarequipos();
        
        header("Location: ../cpanel/events.php?q=CompetitorsUpdated");

}

function CompetitorsforResults($idevento,$tiporesultado){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql = "SELECT idcompetidor, comp.idequipo, nombreequipo, nombredelegacion 
    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d 
    WHERE comp.idequipo = e.idequipo
    AND e.idequipo = c.idequipo
    AND c.idpersona = par.idpersona
    AND par.idpersona = i.idpersona
    AND i.iddelegacion = d.iddelegacion
    AND comp.idevento = $idevento";

    $result = mysqli_query($connection, $sql);

    echo "<div id='dynamicInput' style='float: left;' class='col-md-12'>
                        <hr><hr>
                        <h4>Resultado Parcial del Evento</h4> 
                        <br>
                        <div class='col-md-4' name='caracteristicas'>
                            
                            <label for='nombre[]' class='form-label'>Nombre del Resultado:</label>
                            <input type='text' class='form-control' id='nombre[]' name='nombre[]'>
                            
                            <label for='type[]' class='form-label'>Estado:</label>
                            <select class='form-control' name='type[]' id='type[]' class='form-control'>
                                    <option value='valido' selected>V&aacute;lido</option>
                                    <option value='descalificado'>Descalificado</option>
                                    <option value='doping'>Doping</option>
                                    <option value='no_finalizo'>Sin Finalizar</option>
                            </select>
                            
                            <label for='note[]' class='form-label'>Observaci&oacute;n:</label>
                            <textarea class='form-control' rows='5' name='note[]' id='note[]'></textarea>
                            <br><br>
                        </div>";
                echo "<div name='teamresults' class='col-md-7'>";
                echo "<input type='hidden' name='resulttype[]' id='resulttype[]' value='".$tiporesultado."'>";
    
    while ($row = $result->fetch_assoc()){
        if ($tiporesultado == 'puntos' ){
                    
                        echo " 
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row['nombreequipo']." [".$row['nombredelegacion']."]:</label>
                        <div class='form-inline'>
                        <input type='text' class='form-control' id='idresult[]' name='idresult[]' placeholder='Puntaje'>
                        <label for='idresult[]' class='form-label' style='color:orange;'>Puntos</label></div>";
                         
        }
        elseif ($tiporesultado == 'distancia' ){
                        echo " 
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row['nombreequipo']." [".$row['nombredelegacion']."]:</label>
                        <div class='form-inline'>
                        <input type='text' class='form-control' id='idresult[]' name='idresult[]' placeholder='Distancia en metros'>
                        <label for='idresult[]' class='form-label' style='color:orange;'>Metros</label></div>";
        }
        elseif ($tiporesultado == 'tiempo' ){
                         echo "
                        
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row['nombreequipo']." [".$row['nombredelegacion']."]:</label>
                        
                        <div class='form-inline'> 
                        <select class='form-control' id='idresult1[]' name='idresult[]'>";
                        for($i =0; $i < 1000; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult1[]' class='form-label' style='color:orange;'>Horas&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult2[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult2[]' class='form-label' style='color:orange;'>Minutos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult3[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult3[]' class='form-label' style='color:orange;'>Segundos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult4[]' name='idresult[]'>";
                        for($i =0; $i < 100; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult4[]' class='form-label' style='color:orange;'>Decimas</label>
                        </div>
                        <br>";
        }

    }

    echo "</div></div>";
}

function UpdateResults($txt,$evento){

$dbusername = "toDelete";
$dbpass = "toDelete";

$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
mysqli_select_db($connection, DBNAME);

if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        $connection->close();
}else {

    $sql = "SELECT idresultado from resultado r, competidor c WHERE c.idcompetidor=r.idcompetidor AND c.idevento=$evento";
                                
    echo $sql;
    $result = $connection->query($sql);
    while ($row = $result->fetch_assoc()){
        $sql2 ="DELETE FROM puntos WHERE idresultado=".$row['idresultado']."";
        echo $sql2;
        $result2 = $connection->query($sql2);

        $sql3 ="DELETE FROM distancia WHERE idresultado=".$row['idresultado']."";
        echo $sql3;
        $result3 = $connection->query($sql3);

        $sql4 ="DELETE FROM tiempo WHERE idresultado=".$row['idresultado']."";
        echo $sql4;
        $result4 = $connection->query($sql4);

        $sql5 ="DELETE FROM resultado WHERE idresultado=".$row['idresultado']."";
        echo $sql5;
        $result5 = $connection->query($sql5);  
    }

    $connection->close();   
            
    $data = array();
    $alldata = array();
    $alldata=explode("!",$txt);

    unset($data);
    unset($competidores);
    unset($resultados1);
    unset($resultados2);
    unset($resultados3);
    unset($resultados4);
    $data = array();

//Lectura del resultado Final
    
    $data = explode("/",$alldata[1]);
    $i=0;
    $nombre=" ";
    $tipo=" ";
    $nota=" ";

    $nombre=$data[0];
    $tipo=$data[1];
    $nota=$data[2];
    $tiporesultado=$data[3];

    $competidores = array();
    
    $i=4;
        
    if(($tiporesultado == 'distancia') or ($tiporesultado == 'puntos') ){
        
        $resultados1 = array();
        
        for($x=0; $x<((count($data)-5)/2); $x++){
                
            $competidores[$x]=$data[$i];
            $i++;
            $resultados1[$x]=$data[$i];
            $i++;
        }

    }else{

        $resultados1 = array();
        $resultados2 = array();
        $resultados3 = array();
        $resultados4 = array();

        for($x=0; $x<((count($data)-5)/5); $x++){
                
            $competidores[$x]=$data[$i];
            $i++;
            $resultados1[$x]=$data[$i];
            $i++;
            $resultados2[$x]=$data[$i];
            $i++;
            $resultados3[$x]=$data[$i];
            $i++;
            $resultados4[$x]=$data[$i];
            $i++;
        }
    } 
    switch ($tiporesultado) {
        case 'distancia':
            $resultados = new resultados();
            for($x=0; $x<count($competidores); $x++){

                $Resultado = new Resultado($nombre,$tipo,$nota,1,$resultados1[$x],$competidores[$x]);
                $resultados->insertar($Resultado);
            }
            $resultados->impactar($tiporesultado);
        break;
        case 'puntos':
            $resultados = new resultados();
            for($x=0; $x<count($competidores); $x++){

                $Resultado = new Resultado($nombre,$tipo,$nota,1,$resultados1[$x],$competidores[$x]);
                $resultados->insertar($Resultado);
            }
            $resultados->impactar($tiporesultado);
        break;
        case 'tiempo':
            $resultados = new resultados();

            for($x=0; $x<count($competidores); $x++){

                unset($resultadodetiempo);
                $resultadodetiempo = array($resultados1[$x],$resultados2[$x],$resultados3[$x],$resultados4[$x]);
                $Resultado = new Resultado($nombre,$tipo,$nota,1,$resultadodetiempo,$competidores[$x]);
                $resultados->insertar($Resultado);

            }
            $resultados->impactar($tiporesultado);
        break;
    }
    
        
//Lectura de resultados parciales
    for ($k=2; $k<count($alldata); $k++){

        unset($data);
        unset($competidores);
        unset($resultados1);
        unset($resultados2);
        unset($resultados3);
        unset($resultados4);

        $data = array();

        $data = explode("/",$alldata[$k]);
        
        $i=0;
        $nombre=" ";
        $tipo=" ";
        $tiporesultado=" ";
        $nota=" ";

        $nombre=$data[0];
        $tipo=$data[1];
        $nota=$data[2];
        $tiporesultado=$data[3];

        $competidores = array();
        
        $i=4;
        
        if(($tiporesultado == 'distancia') or ($tiporesultado == 'puntos') ){
        
        $resultados1 = array();
        
            for($x=0; $x<((count($data)-5)/2); $x++){
                
                $competidores[$x]=$data[$i];
                $i++;
                $resultados1[$x]=$data[$i];
                $i++;
            }

        }else{

            $resultados1 = array();
            $resultados2 = array();
            $resultados3 = array();
            $resultados4 = array();

            for($x=0; $x<((count($data)-5)/5); $x++){
                
                $competidores[$x]=$data[$i];
                $i++;
                $resultados1[$x]=$data[$i];
                $i++;
                $resultados2[$x]=$data[$i];
                $i++;
                $resultados3[$x]=$data[$i];
                $i++;
                $resultados4[$x]=$data[$i];
                $i++;
            }

        }
        
        switch ($tiporesultado) {
        case 'distancia':
            $resultados = new resultados();
            for($x=0; $x<count($competidores); $x++){

                $Resultado = new Resultado($nombre,$tipo,$nota,0,$resultados1[$x],$competidores[$x]);
                $resultados->insertar($Resultado);
            }
            $resultados->impactar($tiporesultado);
        break;
        case 'puntos':
            $resultados = new resultados();
            for($x=0; $x<count($competidores); $x++){

                $Resultado = new Resultado($nombre,$tipo,$nota,0,$resultados1[$x],$competidores[$x]);
                $resultados->insertar($Resultado);
            }
            $resultados->impactar($tiporesultado);
        break;
        case 'tiempo':
            $resultados = new resultados();

            for($x=0; $x<count($competidores); $x++){

                unset($resultadodetiempo);
                $resultadodetiempo = array($resultados1[$x],$resultados2[$x],$resultados3[$x],$resultados4[$x]);
                $Resultado = new Resultado($nombre,$tipo,$nota,0,$resultadodetiempo,$competidores[$x]);
                $resultados->insertar($Resultado);

            }
            $resultados->impactar($tiporesultado);
        break;
    }   
        
 }   
}
}

function Fillfinalresult($IdEvento){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql = "SELECT idresultado, nombreresultado, tiporesultado, nota
            FROM resultado r, competidor com
            WHERE r.idcompetidor = com.idcompetidor
            AND com.idevento = $IdEvento
            AND r.final = '1'
            GROUP BY com.idevento";

    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result)!=0){

        while ($row = $result->fetch_assoc()){

          echo "<div id='finalinput1' class='col-md-12'>
                            <hr><hr>
                            <h3>Resultado Final del Evento</h3> 
                            <div class='col-md-4' name='caracteristicas'>
                                <label for='nombre[]' class='form-label'>Nombre del Resultado:</label>
                                <input type='text' class='form-control' id='nombre[]' name='nombre[]' value='".$row['nombreresultado']."'>
                                
                                <label for='type[]' class='form-label'>Estado:</label>
                                <select class='form-control' name='type[]' id='type[]' class='form-control'>";
                                 switch($row['tiporesultado']){
                                    case 'valido':
                                    echo "<option value='valido' selected>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                    case 'descalificado':
                                    echo "<option value='valido'>V&aacute;lido</option>
                                        <option value='descalificado' selected>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                    case 'doping':
                                    echo "<option value='valido'>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping' selected>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                    case 'no_finalizo':
                                    echo "<option value='valido'>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo' selected>Sin Finalizar</option>";
                                    break;
                                    default:
                                    echo "<option value='valido' selected>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                }
                            echo "</select>
                                <label for='note[]' class='form-label'>Observaci&oacute;n:</label>
                                <textarea class='form-control' rows='5' name='note[]' id='note[]'>".$row['nota']."</textarea>
                                <br><br>
                            </div>";
                    echo "<div name='finalinput2' class='col-md-7'>";
                    echo "<div name='dropdowntype' class='col-md-4'>";;////////////////////PARA ARREGLAR  tengo que poner consultar en que tabla esta el resultado y corregir el dropdown
                    echo "<label for='RFTipo' class='form-label'>Cambiar Tipo de Resultado:</label>";

                    $consulta1 = "SELECT idresultado FROM distancia WHERE idresultado=".$row['idresultado']."";
                    $resultado1 = mysqli_query($connection, $consulta1);
                    if(mysqli_num_rows($resultado1)!=0){
                        $tipodropdown = 'distancia';
                    }else{
                        $consulta2 = "SELECT idresultado FROM puntos WHERE idresultado=".$row['idresultado']."";
                        $resultado2 = mysqli_query($connection, $consulta2);
                        if(mysqli_num_rows($resultado2)!=0){
                            $tipodropdown = 'puntos';
                        }else{$tipodropdown = 'tiempo';}
                    }
                    switch ($tipodropdown) {
                        case 'puntos':
                        echo "<select class='form-control' name='RFTipo' id='RFTipo' class='form-control class='col-md-4'' onchange='Fillplayersonfinal()'>
                            <option value='puntos' selected>&nbsp;Puntos&nbsp;</option>
                            <option value='tiempo'>&nbsp;Tiempo&nbsp;</option>
                            <option value='distancia'>&nbsp;Distancia&nbsp;</option>";    
                        break;
                        case 'distancia':
                        echo "<select class='form-control' name='RFTipo' id='RFTipo' class='form-control class='col-md-4'' onchange='Fillplayersonfinal()'>
                            <option value='puntos'>&nbsp;Puntos&nbsp;</option>
                            <option value='tiempo'>&nbsp;Tiempo&nbsp;</option>
                            <option value='distancia' selected>&nbsp;Distancia&nbsp;</option>";    
                        break;
                        case 'tiempo':
                        echo "<select class='form-control' name='RFTipo' id='RFTipo' class='form-control class='col-md-4'' onchange='Fillplayersonfinal()'>
                            <option value='puntos'>&nbsp;Puntos&nbsp;</option>
                            <option value='tiempo' selected>&nbsp;Tiempo&nbsp;</option>
                            <option value='distancia'>&nbsp;Distancia&nbsp;</option>";    
                        break;
                    }     
              echo "</select></div>";
              echo "<br><br>";
              echo "<div name='dynamiccompetitors' id='dynamiccompetitors'  style='float: left;' class='col-md-12'>";
            $sql2="SELECT idresultado FROM distancia WHERE idresultado=".$row['idresultado']."";
            $result2 = mysqli_query($connection, $sql2);
            if(mysqli_num_rows($result2)!=0){

                $sql3 = "SELECT comp.idcompetidor, comp.idequipo, nombreequipo, nombredelegacion, metros 
                    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d, resultado r, distancia dis 
                    WHERE comp.idequipo = e.idequipo
                    AND e.idequipo = c.idequipo
                    AND c.idpersona = par.idpersona
                    AND par.idpersona = i.idpersona
                    AND i.iddelegacion = d.iddelegacion
                    AND r.idcompetidor = comp.idcompetidor
                    AND r.idresultado = dis.idresultado
                    AND r.final = 1
                    AND comp.idevento = $IdEvento";

                $result3 = mysqli_query($connection, $sql3);

                while ($row3 = $result3->fetch_assoc()){
                    
                            echo " 
                            <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row3['idcompetidor']."'>
                            <label for='idresult[]' class='form-label' style='color:blue;'>".$row3['nombreequipo']." [".$row3['nombredelegacion']."]:</label>
                            <div class='form-inline'>
                            <input type='text' class='form-control' id='idresult[]' name='idresult[]' value='".$row3['metros']."'>
                            <label for='idresult[]' class='form-label' style='color:orange;'>Metros</label></div>";
                }
            }
            else{

                $sql4="SELECT idresultado FROM puntos WHERE idresultado=".$row['idresultado']."";
                $result4 = mysqli_query($connection, $sql4);
                if(mysqli_num_rows($result4)!=0){

                     $sql3 = "SELECT comp.idcompetidor, comp.idequipo, nombreequipo, nombredelegacion, puntaje 
                    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d, resultado r, puntos p 
                    WHERE comp.idequipo = e.idequipo
                    AND e.idequipo = c.idequipo
                    AND c.idpersona = par.idpersona
                    AND par.idpersona = i.idpersona
                    AND i.iddelegacion = d.iddelegacion
                    AND r.idcompetidor = comp.idcompetidor
                    AND r.idresultado = p.idresultado
                    AND r.final = 1
                    AND comp.idevento = $IdEvento";

                    $result3 = mysqli_query($connection, $sql3);

                    while ($row3 = $result3->fetch_assoc()){
                    
                            echo " 
                            <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row3['idcompetidor']."'>
                            <label for='idresult[]' class='form-label' style='color:blue;'>".$row3['nombreequipo']." [".$row3['nombredelegacion']."]:</label>
                            <div class='form-inline'>
                            <input type='text' class='form-control' id='idresult[]' name='idresult[]' value='".$row3['puntaje']."'>
                            <label for='idresult[]' class='form-label' style='color:orange;'>Puntos</label></div>";
                    }
                }else{

                    $sql3 = "SELECT comp.idcompetidor, comp.idequipo, nombreequipo, nombredelegacion, hora, minuto, segundo, decima 
                    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d, resultado r, tiempo t 
                    WHERE comp.idequipo = e.idequipo
                    AND e.idequipo = c.idequipo
                    AND c.idpersona = par.idpersona
                    AND par.idpersona = i.idpersona
                    AND i.iddelegacion = d.iddelegacion
                    AND r.idcompetidor = comp.idcompetidor
                    AND r.idresultado = t.idresultado
                    AND r.final = 1
                    AND comp.idevento = $IdEvento";

                    $result3 = mysqli_query($connection, $sql3);

                    while ($row3 = $result3->fetch_assoc()){
                    
                         echo "
                        
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row3['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row3['nombreequipo']." [".$row3['nombredelegacion']."]:</label>
                        
                        <div class='form-inline'> 
                        <select class='form-control' id='idresult1[]' name='idresult[]'>";
                        for($i =0; $i < 1000; $i++){ 
                            if ($row3['hora']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);    
                            }
                        }
                        echo "</select>
                        <label for='idresult1[]' class='form-label' style='color:orange;'>Horas&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult2[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                            if ($row3['minuto']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);     
                            }
                        }
                        echo "</select>
                        <label for='idresult2[]' class='form-label' style='color:orange;'>Minutos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult3[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                            if ($row3['segundo']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);     
                            }
                        }
                        echo "</select>
                        <label for='idresult3[]' class='form-label' style='color:orange;'>Segundos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult4[]' name='idresult[]'>";
                        for($i =0; $i < 100; $i++){ 
                            if ($row3['decima']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);     
                            }
                        }
                        echo "</select>
                        <label for='idresult4[]' class='form-label' style='color:orange;'>Decimas</label>
                        </div>
                        <br>";
                    }
                }
            } 
            echo "<hr><hr><br><br></div></div></div>";
        }
    }
    else{
            echo "<div id='finalinput1' class='col-md-12'>
                        <hr><hr>
                        <h3>Resultado Final del Evento</h3> 
                        <br>
                    <div class='col-md-4' name='caracteristicas'>
                                
                    <label for='nombre[]' class='form-label'>Nombre del Resultado:</label>
                    <input type='text' class='form-control' id='nombre[]' name='nombre[]'>
                                
                    <label for='type[]' class='form-label'>Estado:</label>
                    <select class='form-control' name='type[]' id='type[]' class='form-control'>";
                                
                    echo "<option value='valido' selected>V&aacute;lido</option>
                          <option value='descalificado'>Descalificado</option>
                          <option value='doping'>Doping</option>
                          <option value='no_finalizo'>Sin Finalizar</option>";
              echo "</select>
                    <label for='note[]' class='form-label'>Observaci&oacute;n:</label>
                    <textarea class='form-control' rows='5' name='note[]' id='note[]'></textarea>
                    <br><br>
                    </div>";
              echo "<div name='finalinput2' class='col-md-7'>";
                    echo "<div name='dropdowntype' class='col-md-4'>";
                    echo "<label for='RFTipo' class='form-label'>Cambiar Tipo de Resultado:</label>
                            <select class='form-control' name='RFTipo' id='RFTipo' class='form-control' onchange='Fillplayersonfinal()'>
                                    <option value='puntos' selected>&nbsp;Puntos&nbsp;</option>
                                    <option value='tiempo'>&nbsp;Tiempo&nbsp;</option>
                                    <option value='distancia'>&nbsp;Distancia&nbsp;</option>
                            </select>
                            <br>
                            </div>";
                    echo "<br>";
                    echo "<div name='dynamiccompetitors'  style='float: left;' id='dynamiccompetitors'class='col-md-12'>";

                $sql6 = "SELECT idcompetidor, comp.idequipo, nombreequipo, nombredelegacion 
                      FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d 
                      WHERE comp.idequipo = e.idequipo
                      AND e.idequipo = c.idequipo
                      AND c.idpersona = par.idpersona
                      AND par.idpersona = i.idpersona
                      AND i.iddelegacion = d.iddelegacion
                      AND comp.idevento = $IdEvento";

                $result6 = mysqli_query($connection, $sql6);

            while ($row6 = $result6->fetch_assoc()){
                    echo "<input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row6['idcompetidor']."'>
                          <label for='idresult[]' class='form-label' style='color:blue;'>".$row6['nombreequipo']." [".$row6['nombredelegacion']."]:</label>
                          <div class='form-inline'>
                          <input type='text' class='form-control' id='idresult[]' name='idresult[]' placeholder='Puntaje'>
                          <label for='idresult[]' class='form-label' style='color:orange;'>Puntos</label>
                          </div>";
            }
              
        }
        echo "        
                        <br><br>
                </div>
                </div>";
        $connection->close();
}

function fillplayersresults($idevento, $tiporesultado){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql = "SELECT idcompetidor, comp.idequipo, nombreequipo, nombredelegacion 
                      FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d 
                      WHERE comp.idequipo = e.idequipo
                      AND e.idequipo = c.idequipo
                      AND c.idpersona = par.idpersona
                      AND par.idpersona = i.idpersona
                      AND i.iddelegacion = d.iddelegacion
                      AND comp.idevento = $idevento";

    $result = mysqli_query($connection, $sql);

    while ($row = $result->fetch_assoc()){

        if ($tiporesultado == 'puntos' ){
                    
                        echo " 
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row['nombreequipo']." [".$row['nombredelegacion']."]:</label>
                        <div class='form-inline'>
                        <input type='text' class='form-control' id='idresult[]' name='idresult[]' placeholder='Puntaje'>
                        <label for='idresult[]' class='form-label' style='color:orange;'>Puntos</label></div>";
                         
        }
        elseif ($tiporesultado == 'distancia' ){
                        echo " 
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row['nombreequipo']." [".$row['nombredelegacion']."]:</label>
                        <div class='form-inline'>
                        <input type='text' class='form-control' id='idresult[]' name='idresult[]' placeholder='Distancia en metros'>
                        <label for='idresult[]' class='form-label' style='color:orange;'>Metros</label></div>";
        }
        elseif ($tiporesultado == 'tiempo' ){
                        echo "
                        
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row['nombreequipo']." [".$row['nombredelegacion']."]:</label>
                        
                        <div class='form-inline'> 
                        <select class='form-control' id='idresult1[]' name='idresult[]'>";
                        for($i =0; $i < 1000; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult1[]' class='form-label' style='color:orange;'>Horas&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult2[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult2[]' class='form-label' style='color:orange;'>Minutos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult3[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult3[]' class='form-label' style='color:orange;'>Segundos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult4[]' name='idresult[]'>";
                        for($i =0; $i < 100; $i++){ 
                        printf('<option value="%d">%d</option>', $i, $i);
                        }
                        echo "</select>
                        <label for='idresult4[]' class='form-label' style='color:orange;'>Decimas</label>
                        </div>
                        <br>";

        }
    }
    
    $connection->close();
}

function Fillpartialresults($idevento){

    $dbuser = "infoSelect";
    $dbpass = "infoselectpass";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    }

    $sql = "SELECT idresultado, nombreresultado, tiporesultado, nota
            FROM resultado r, competidor com
            WHERE r.idcompetidor = com.idcompetidor
            AND com.idevento = $idevento
            AND r.final = '0'
            GROUP BY nombreresultado";

    $result = mysqli_query($connection, $sql);

    while ($row = $result->fetch_assoc()){

        echo "<div id='dynamicInput' class='col-md-12' style='float: left;'>
                        <hr><hr>
                        <h4>Resultado Parcial del Evento</h4> 
                        <br>
                        <div class='col-md-6' name='caracteristicas'>
                            
                            <label for='nombre[]' class='form-label'>Nombre del Resultado:</label>
                            <input type='text' class='form-control' id='nombre[]' name='nombre[]' value='".$row['nombreresultado']."'>
                            
                            <label for='type[]' class='form-label'>Estado:</label>
                            <select class='form-control' name='type[]' id='type[]' class='form-control'>";
                                    switch($row['tiporesultado']){
                                    case 'valido':
                                    echo "<option value='valido' selected>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                    case 'descalificado':
                                    echo "<option value='valido'>V&aacute;lido</option>
                                        <option value='descalificado' selected>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                    case 'doping':
                                    echo "<option value='valido'>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping' selected>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                    case 'no_finalizo':
                                    echo "<option value='valido'>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo' selected>Sin Finalizar</option>";
                                    break;
                                    default:
                                    echo "<option value='valido' selected>V&aacute;lido</option>
                                        <option value='descalificado'>Descalificado</option>
                                        <option value='doping'>Doping</option>
                                        <option value='no_finalizo'>Sin Finalizar</option>";
                                    break;
                                }
                            echo "</select>

                            <label for='note[]' class='form-label'>Observaci&oacute;n:</label>
                            <textarea class='form-control' rows='5' name='note[]' id='note[]'>".$row['nota']."</textarea>
                            <br><br>
                        </div>";

                echo "<div name='teamresults' class='col-md-7'>";

        $sql2 = "SELECT idresultado FROM distancia WHERE idresultado=".$row['idresultado']." ";

        $result2 = mysqli_query($connection, $sql2);

        if(mysqli_num_rows($result2)!=0){
            
                $sql3 = "SELECT comp.idcompetidor, comp.idequipo, nombreequipo, nombredelegacion, metros 
                    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d, resultado r, distancia dis 
                    WHERE comp.idequipo = e.idequipo
                    AND e.idequipo = c.idequipo
                    AND c.idpersona = par.idpersona
                    AND par.idpersona = i.idpersona
                    AND i.iddelegacion = d.iddelegacion
                    AND r.idcompetidor = comp.idcompetidor
                    AND r.idresultado = dis.idresultado
                    AND r.final = 0
                    AND comp.idevento = $idevento
                    AND r.nombreresultado= '".$row['nombreresultado']."'";

                $result3 = mysqli_query($connection, $sql3);
                echo "<input type='hidden' name='resulttype[]' id='resulttype[]' value='distancia'>";
                while ($row3 = $result3->fetch_assoc()){
                    
                            echo " 
                            <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row3['idcompetidor']."'>
                            <label for='idresult[]' class='form-label' style='color:blue;'>".$row3['nombreequipo']." [".$row3['nombredelegacion']."]:</label>
                            <div class='form-inline'>
                            <input type='text' class='form-control' id='idresult[]' name='idresult[]' value='".$row3['metros']."'>
                            <label for='idresult[]' class='form-label' style='color:orange;'>Metros</label></div>";
                }
        }else{

            $sql4 = "SELECT idresultado FROM tiempo WHERE idresultado=".$row['idresultado']." ";

            $result4 = mysqli_query($connection, $sql4);

            if(mysqli_num_rows($result4)!=0){

                $sql3 = "SELECT comp.idcompetidor, comp.idequipo, nombreequipo, nombredelegacion, hora, minuto, segundo, decima 
                    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d, resultado r, tiempo t 
                    WHERE comp.idequipo = e.idequipo
                    AND e.idequipo = c.idequipo
                    AND c.idpersona = par.idpersona
                    AND par.idpersona = i.idpersona
                    AND i.iddelegacion = d.iddelegacion
                    AND r.idcompetidor = comp.idcompetidor
                    AND r.idresultado = t.idresultado
                    AND r.final = 0
                    AND comp.idevento = $idevento
                    AND r.nombreresultado= '".$row['nombreresultado']."'";

                $result3 = mysqli_query($connection, $sql3);
                echo "<input type='hidden' name='resulttype[]' id='resulttype[]' value='tiempo'>";
                while ($row3 = $result3->fetch_assoc()){
                    
                    echo "
                        
                        <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row3['idcompetidor']."'>
                        <label for='idresult[]' class='form-label' style='color:blue;'>".$row3['nombreequipo']." [".$row3['nombredelegacion']."]:</label>
                        
                        <div class='form-inline'> 
                        <select class='form-control' id='idresult1[]' name='idresult[]'>";
                        for($i =0; $i < 1000; $i++){ 
                            if ($row3['hora']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);    
                            }
                        }
                    echo "</select>
                        <label for='idresult1[]' class='form-label' style='color:orange;'>Horas&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult2[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                            if ($row3['minuto']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);     
                            }
                        }
                    echo "</select>
                        <label for='idresult2[]' class='form-label' style='color:orange;'>Minutos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult3[]' name='idresult[]'>";
                        for($i =0; $i < 60; $i++){ 
                            if ($row3['segundo']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);     
                            }
                        }
                    echo "</select>
                        <label for='idresult3[]' class='form-label' style='color:orange;'>Segundos&nbsp;&nbsp;</label>

                        <select class='form-control' id='idresult4[]' name='idresult[]'>";
                        for($i =0; $i < 100; $i++){ 
                            if ($row3['decima']==$i){
                                printf('<option value="%d" selected>%d</option>', $i, $i);
                            }else{
                                printf('<option value="%d">%d</option>', $i, $i);     
                            }
                        }
                    echo "</select>
                        <label for='idresult4[]' class='form-label' style='color:orange;'>Decimas</label>
                        </div>
                        <br>";
                }
            }
            else{
                    

                $sql3 = "SELECT comp.idcompetidor, comp.idequipo, nombreequipo, nombredelegacion, puntaje 
                    FROM competidor comp, conforma c, equipo e, participante par, integra2 i, delegacion d, resultado r, puntos p 
                    WHERE comp.idequipo = e.idequipo
                    AND e.idequipo = c.idequipo
                    AND c.idpersona = par.idpersona
                    AND par.idpersona = i.idpersona
                    AND i.iddelegacion = d.iddelegacion
                    AND r.idcompetidor = comp.idcompetidor
                    AND r.idresultado = p.idresultado
                    AND r.final = 0
                    AND comp.idevento = $idevento
                    AND r.nombreresultado= '".$row['nombreresultado']."'";

                $result3 = mysqli_query($connection, $sql3);
                echo "<input type='hidden' name='resulttype[]' id='resulttype[]' value='puntos'>";

                while ($row3 = $result3->fetch_assoc()){
                    
                    echo " 
                            <input type='hidden' name='idcompetitor[]' id='idcompetitor[]' value='".$row3['idcompetidor']."'>
                            <label for='idresult[]' class='form-label' style='color:blue;'>".$row3['nombreequipo']." [".$row3['nombredelegacion']."]:</label>
                            <div class='form-inline'>
                            <input type='text' class='form-control' id='idresult[]' name='idresult[]' value='".$row3['puntaje']."'>
                            <label for='idresult[]' class='form-label' style='color:orange;'>Puntos</label></div>";
                }
            }      
        } 
    }
    echo "</div></div></div>";
    $connection->close();
}

//////////////////////////////////////////////////////
//      CONTROL PARA SABER QUÉ FUNCIÓN LLAMAR      //
/////////////////////////////////////////////////////

    if(isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case "addEvent":
                addEvent($_REQUEST['nombre'],$_REQUEST['fase'],$_REQUEST['categoria'], $_REQUEST['fecha'], $_REQUEST['hora'], $_REQUEST['lugar'], $_REQUEST['estado']);
                break;
            case "deleteEvent":
                DeleteEvent($_REQUEST['id']);
                break;
            case "selectTourny":
                fillPhasesdropdown($_REQUEST['tournyId'],0);
                break;
            case "modEvent":
                modEvent($_REQUEST['id'],$_REQUEST['nombre'],$_REQUEST['fase'],$_REQUEST['categoria'], $_REQUEST['fecha'], $_REQUEST['hora'], $_REQUEST['lugar'], $_REQUEST['estado']);
                break;
            case "UpdateCompetitors":
                UpdateCompetitors($_REQUEST['idevento'],$_REQUEST['equipos']);
                break;
            case "fillCompetitors":
                FillCompetitors($_REQUEST['torneo'],$_REQUEST['categoria']);
                break;
            case "fillActiveCompetitors":
                FillActiveCompetitors($_REQUEST['idevento']);
                break;
            case "fillResults":
                CompetitorsforResults($_REQUEST['evento'],$_REQUEST['tipo']);
                break;
            case "Manageresult":
                UpdateResults($_REQUEST['parametros'],$_REQUEST['evento']);
                break;
            case "fillfinalResults":
                Fillfinalresult($_REQUEST['evento']);
                break;
            case "fillpartialResults":
                Fillpartialresults($_REQUEST['evento']);
                break;
            case "fillplayers":
                fillplayersresults($_REQUEST['evento'],$_REQUEST['tipo']);
                break;
        }
    }
?>