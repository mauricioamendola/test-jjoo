<?php
    session_start();

    $servname = "localhost";
    $dbuser = "root";
    
    $connection = new mysqli($servname, $dbuser, "", "olympicinfoapp");
    
	$year=substr($_REQUEST['year'],0,4);
	
    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    } else {
        mysqli_select_db($connection, "olympicinfoapp"); '".$ampliada."'
        echo "INSERT INTO torneo(NombreTorneo,  FechaTorneo) VALUES('".$_REQUEST['torneoName']."','".$year."')";
        echo "<br>";
        $sql = "INSERT INTO torneo(NombreTorneo,  FechaTorneo) VALUES('".$_REQUEST['torneoName']."','".$year."')";
        /*$query = $connection->query($sql);*/
        $connection->query($sql);
        $connection->close();

        echo "SELECT IdTorneo FROM torneo WHERE NombreTorneo='".$_REQUEST['torneoName']."'";
        echo "<br>";
        $getId = new mysqli($servname, $dbuser, "", "olympicinfoapp");

        $sqlid = "SELECT IdTorneo FROM torneo WHERE NombreTorneo='".$_REQUEST['torneoName']."'";

        $result = mysqli_query($getId, $sqlid);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($getId));
            exit();
        }

        while ($row = $result->fetch_assoc()) {
            $sportid = $row['IdTorneo'];
        }

    }
?>
