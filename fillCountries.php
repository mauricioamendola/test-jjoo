<?php

    $servname = "localhost";
    $dbusername = "infoSelect";
    $dbpass = "infoselectpass";

    $regionid = $_REQUEST["regionid"];

    $connection = new mysqli($servname, $dbusername, $dbpass);
    echo "<h1>Hola desde PHP</h1>";
    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    } else {
        mysqli_select_db($connection, "olympicinfoapp");
        $sql = "SELECT idpais, nombrepais FROM pais WHERE idregion='".$regionid."'";
        echo "SELECT idpais, nombrepais FROM pais WHERE idregion='".$regionid."'";
        /*$query = $connection->query($sql);*/
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
        }
    }

    echo "<select class='selectpicker' id='pais'>";

    while ($row = $result->fetch_assoc()) {
        echo "<option value='".$row['idpais']."'>".$row['nombrepais']."</option>";
    }

    echo "</select>";

?>
