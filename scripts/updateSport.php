<?php
    session_start();
    include_once("dbcfg.php");

    $servname = "localhost";
    $dbuser = "toUpdate";
    $dbpass = "toUpdate";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    } else {
        mysqli_select_db($connection, DBNAME);
        $connection->set_charset("utf8");
        echo "UPDATE disciplina set nombredisciplina='".$_REQUEST['sportName']."', descripciondisciplina='".$_REQUEST['sportDescription']."' WHERE iddisciplina='".$_REQUEST['sportId']."'";
        echo "<br>";
        $sql = "UPDATE disciplina set nombredisciplina='".$_REQUEST['sportName']."', descripciondisciplina='".$_REQUEST['sportDescription']."' WHERE iddisciplina='".$_REQUEST['sportId']."'";
        /*$query = $connection->query($sql);*/
        $connection->query($sql);
        $connection->close();
    }
    header("Location: ../cpanel/sports.php?q=update");
?>
