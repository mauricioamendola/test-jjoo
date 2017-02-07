<?php
    include_once('includes/fases.php');
    include_once('dbcfg.php');

    function getPhasesTable(){

        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $sql = "SELECT comp.idcompetencia, nombrecompetencia, CONCAT(nombretorneo,'(',fechatorneo,')') as torneo, CONCAT(nombreDisciplina,'(',nombreCategoria,')') as catdisc, TipoCompetencia
                    FROM torneo t, competencia comp 
                    LEFT JOIN evento ev ON comp.idcompetencia=ev.idcompetencia 
                    LEFT JOIN competidor co ON ev.idevento=co.idevento
                    LEFT JOIN equipo e ON e.idequipo=co.idequipo
                    LEFT JOIN categoria cat ON cat.idcategoria=e.idcategoria
                    LEFT JOIN disciplina di ON di.iddisciplina=cat.iddisciplina
                    WHERE t.idtorneo=comp.idtorneo
                    GROUP BY idcompetencia
                    ORDER BY torneo DESC, catdisc DESC, nombrecompetencia DESC";
            
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }



        while ($row = $result->fetch_assoc()){

            echo "<tr>";
            echo "<td>".$row['idcompetencia']."</td>";
            $PhaseName = utf8_encode($row['nombrecompetencia']);
            $PhaseTournament = utf8_encode($row['torneo']);
            $PhaseCategory = utf8_encode($row['catdisc']);
            $PhaseType = utf8_encode($row['TipoCompetencia']);
            
            echo "<td>".$PhaseName."</td>";
            echo "<td>".$PhaseTournament."</td>";
            echo "<td>".$PhaseCategory."</td>";
            echo "<td>".$PhaseType."</td>";
            $pname = urlencode($row['nombrecompetencia']);
            $uri = "modPhase.php?id=".$row['idcompetencia']."&name=".$pname."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeletePhase(".$row['idcompetencia'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "</tr>";     
        }
        $connection->close();
    }

    function getFinalPhasesTable(){

        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $sql = "SELECT comp.idcompetencia, nombrecompetencia, CONCAT(nombretorneo,'(',fechatorneo,')') as torneo, CONCAT(nombreDisciplina,'(',nombreCategoria,')') as catdisc, TipoCompetencia
                    FROM torneo t
                    LEFT JOIN competencia comp ON t.idtorneo=comp.idtorneo
                    LEFT JOIN evento ev ON comp.idcompetencia=ev.idcompetencia 
                    LEFT JOIN competidor co ON ev.idevento=co.idevento
                    LEFT JOIN equipo e ON e.idequipo=co.idequipo
                    LEFT JOIN categoria cat ON cat.idcategoria=e.idcategoria
                    LEFT JOIN disciplina di ON di.iddisciplina=cat.iddisciplina
                    WHERE comp.TipoCompetencia = 'final'
                    OR comp.TipoCompetencia = 'semifinal' 
                    GROUP BY idcompetencia
                    ORDER BY torneo DESC, catdisc DESC, nombrecompetencia DESC";
            
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }



        while ($row = $result->fetch_assoc()){

            echo "<tr>";
            echo "<td>".$row['idcompetencia']."</td>";
            $PhaseName = utf8_encode($row['nombrecompetencia']);
            $PhaseTournament = utf8_encode($row['torneo']);
            $PhaseCategory = utf8_encode($row['catdisc']);
            
            
            echo "<td>".$PhaseName."</td>";
            echo "<td>".$PhaseTournament."</td>";
            echo "<td>".$PhaseCategory."</td>";
            $pname = urlencode($row['nombrecompetencia']);
            $uri = "Medals.php?id=".$row['idcompetencia']."&name=".$pname."";
            echo "<td><button type='button' class='btn btn-success btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspGestionar Medallas</button></td>";
            echo "</tr>";     
        }
        $connection->close();
    }


   

    function addPhase($name,$idtourny,$type)
    {

        $fases= new fases();
        $fase= new Fase(0,$name,$type,$idtourny);
        $fases->insertar($fase);
        $fases->impactar();
        header("Location: ../cpanel/phases.php?q=phaseadded");
        
    }
    
    function UpdatePhase($IdFase,$IdTorneo,$Nombre,$Tipo){

        $fases= new fases();
        $fase= new Fase($IdFase,$Nombre,$Tipo,$IdTorneo);
        $fases->insertar($fase);
        $fases->actualizar();
        header("Location: ../cpanel/phases.php?q=phaseupdated");
        
    }

    function DeletePhase($idfase){

        
            $fases = new fases();
            $fase = new fase($idfase,'','','');
            $fases->insertar($fase);
            $fases->delete();
            header("Location: ../cpanel/phases.php?q=phasedeleted");
    
    }



    function fillUpdatePhase($id){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";
        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM competencia WHERE idcompetencia=$id";
        $result = $connection->query($sql);
        if (!$result) {
            printf("Error1: %s\n", mysqli_error($connection));
            exit();
        }

        while ($row = $result->fetch_assoc()){
                echo "<h1 class='page-header'>&nbsp&nbsp&nbspModificando Participante Nº<kbd>".utf8_encode($id).", ".$row['NombreCompetencia']."</kbd></h1>";
                echo "<form action='../scripts/fillPhases.php?q=updatephase' method='post' enctype='multipart/form-data' role='form'>";
                echo "<div class='form-group'>
                    <input type='hidden' name='IdFase' id='IdFase' value='".$id."'>
                    </div>";
                echo "<div class='form-group'>
                        <label for='PhaseName' class='form-label'>Nombre de la Fase:</label>
                        <input type='text' class='form-control' name='PhaseName' id='PhaseName' value='".$row['NombreCompetencia']."' required oninvalid='this.setCustomValidity('Campo de Nombre Vacío')' oninput='setCustomValidity('')'>
                        </div>";
                echo "<div class='form-group'>
                            <label for='tourny' class='form-label'>Seleccionar torneo:</label>
                            <select name='tourny' id='tourny' style='display: inline; width: 100%;' class='form-control'>";
                                
                                    include_once "../scripts/dataMgmt.php";
                                    fillTournyDropdown($row['IdTorneo']);
                                
                echo  "     </select>
                        </div>";
                        
                echo "
                        <div id='tipo' class='form-group'>
                            <label for='tipo' class='form-label'>Etapa/Tipo:</label>
                            <select name='tipo' id='tipo' class='form-control'>";
                            switch($row['TipoCompetencia']){
                                case 'grupo':
                                    echo "<option selected value='grupo'>Grupo</option>
                                        <option value='octavos'>Octavos</option>
                                        <option value='cuartos'>Cuartos</option>
                                        <option value='semifinal'>Semifinal</option>
                                        <option value='tercer_puesto'>Tercer Puesto</option>
                                        <option value='final'>Final</option>";
                                    break;
                                case 'octavos':
                                    echo "<option value='grupo'>Grupo</option>
                                        <option selected value='octavos'>Octavos</option>
                                        <option value='cuartos'>Cuartos</option>
                                        <option value='semifinal'>Semifinal</option>
                                        <option value='tercer_puesto'>Tercer Puesto</option>
                                        <option value='final'>Final</option>";
                                    break;
                                case 'cuartos':
                                    echo "<option value='grupo'>Grupo</option>
                                        <option value='octavos'>Octavos</option>
                                        <option selected value='cuartos'>Cuartos</option>
                                        <option value='semifinal'>Semifinal</option>
                                        <option value='tercer_puesto'>Tercer Puesto</option>
                                        <option value='final'>Final</option>";
                                    break;
                                case 'semifinal':
                                    echo "<option selected value='grupo'>Grupo</option>
                                        <option value='octavos'>Octavos</option>
                                        <option value='cuartos'>Cuartos</option>
                                        <option selected value='semifinal'>Semifinal</option>
                                        <option value='tercer_puesto'>Tercer Puesto</option>
                                        <option value='final'>Final</option>";
                                    break;
                                case 'tercer_puesto':
                                    echo "<option value='grupo'>Grupo</option>
                                        <option value='octavos'>Octavos</option>
                                        <option value='cuartos'>Cuartos</option>
                                        <option value='semifinal'>Semifinal</option>
                                        <option selected value='tercer_puesto'>Tercer Puesto</option>
                                        <option value='final'>Final</option>";
                                    break;
                                case 'final':
                                    echo "<option selected value='grupo'>Grupo</option>
                                        <option value='octavos'>Octavos</option>
                                        <option value='cuartos'>Cuartos</option>
                                        <option value='semifinal'>Semifinal</option>
                                        <option value='tercer_puesto'>Tercer Puesto</option>
                                        <option selected value='final'>Final</option>";
                                    break;
                                }
                            
                        echo " </select>
                        </div>
                        <br><br><br>
                        <button type='submit' class='btn btn-success'>Modificar Fase</button>";
                
        }        
    }

    function fillMedals($id){

        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";
        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }

        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");
        $sql = "SELECT TipoCompetencia FROM competencia WHERE idcompetencia=$id";

        $result = $connection->query($sql);
        if (!$result) {
            printf("Error1: %s\n", mysqli_error($connection));
            exit();
        }

        while ($row = $result->fetch_assoc()){
            $tipo=$row['TipoCompetencia'];
        }

        if ($tipo=='semifinal'){

            $sql1 = "SELECT x.idcompetidor, nombreequipo FROM evento w, competidor x, competencia y, equipo z 
            WHERE w.idcompetencia= y.idcompetencia
            AND x.idevento=w.idevento
            AND x.idequipo=z.idequipo  
            AND w.idcompetencia=$id";

            $result1 = $connection->query($sql1);
            if (!$result1) {
                printf("Error1: %s\n", mysqli_error($connection));
                exit();
            }

            while ($row1 = $result1->fetch_assoc()){
                
            }
        }
    }
    

    ////////////////////////////////////////////////////////////////////////////
    // De acá para abajo se manejan los casos en los que se llama el archivo. //
    ////////////////////////////////////////////////////////////////////////////

    if (isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case 'addPhase':
                addPhase($_REQUEST['PhaseName'],$_REQUEST['tourny'],$_REQUEST['tipo']);
                break;
            case 'deletePhase':
                DeletePhase($_REQUEST['id']);
                break;
            case 'updatephase':
                UpdatePhase($_REQUEST['IdFase'],$_REQUEST['tourny'],$_REQUEST['PhaseName'],$_REQUEST['tipo'] );
                break;
            
        }
    }
    

?>