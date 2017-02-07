<?php
    include_once("dbcfg.php");

    $regionId = 0;
    $countryId = 0;
    $athleteId = 0;

    function fillRegions(){

        $servname = "localhost";
        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT idregion, nombreregion FROM region ORDER BY nombreregion";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        echo "<select class='form-control' name='region' id='region' onchange='fillCountries(this.value)' required oninvalid='this.setCustomValidity('Campo de Iso Vacío')'";
        echo "<option selected='selected'>Seleccionar una región</option>";

        while ($row = $result->fetch_assoc()) {
            echo "<option id='regionPick' value='".$row['idregion']."'>".$row['nombreregion']."</option>";
        }

        echo "</select>";
    }

    function getRegionsTable(){
        $servname = "localhost";
        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT idregion, nombreregion FROM region ORDER BY nombreregion";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['idregion']."</td>";
            echo "<td>".$row['nombreregion']."</td>";
            $pais = urlencode($row['nombreregion']);
            $uri = "modregion.php?id=".$row['idregion']."&name=".$pais."";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteRegion(".$row['idregion'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "<td><button type='button' class='btn btn-success btn-xs' id='".$row['idregion']."' onclick='changeTable(this.id)'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspSeleccionar</button></td>";
            echo "</tr>";
        }


    }

    function deleteRegion($id){
        $dbusername = "toDelete";
        $dbpass = "toDelete";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        echo "entro en funcion <br>";

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "DELETE FROM region WHERE idregion=".$id.";";
            echo $sql;
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
            header("Location: ../cpanel/countries.php?q=deleteSuccess");
        }
    }

    function updateRegion($id, $name){
        $dbuser = "toUpdate";
        $dbpass = "toUpdate";

        echo "entro en funcion<br>";

        $update = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

        if ($update->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            echo "entro en sql<br>";
            mysqli_select_db($update, DBNAME);
            $sql = "UPDATE region set NombreRegion='$name' WHERE IdRegion=".intval($id)."";
            echo $sql."<br>";
            /*$query = $connection->query($sql);*/
            $res = $update->query($sql) or die(mysqli_error($update));
            $update->close();
        }
        header("Location: ../cpanel/countries.php?q=update");
    }

    function fillTournamentsTable(){
        $dbuser = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbuser, $dbpass);

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

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['IdTorneo']."</td>";
            echo "<td>".$row['FechaTorneo']."</td>";
            $torneo = urlencode($row['NombreTorneo']);
            $uri = "updateTourny.php?id=".$row['IdTorneo']."&name=".$torneo."";
            echo "<td>".utf8_encode($row['NombreTorneo'])."</td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDelete(".$row['IdTorneo'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>";
            echo "</tr>";
        }
    }

    
    //////////////////////////////////////////////////////
    //      CONTROL PARA SABER QUÉ FUNCIÓN LLAMAR       //
    //////////////////////////////////////////////////////

    if(isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case "deleteRegion":
                deleteRegion($_REQUEST['id']);
                break;
            case "updateRegion":
                updateRegion($_REQUEST['regionId'], $_REQUEST['regionName']);
                break;
        }
    }

?>
