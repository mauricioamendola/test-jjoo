<?php
    include_once "scripts/dbcfg.php";

    session_start();
    $dbuser = "toInsert";
    $dbpass = "toInsert";

    $connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    } else {
        $sql = "INSERT INTO persona VALUES(0,'".$_POST['username']."','".$_POST['email']."','".$_POST['firstname']."','".$_POST['lastname']."','',1)";
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql2 = "INSERT INTO logins VALUES('".$_POST['username']."', '".$password."')";
        /*$query = $connection->query($sql);*/
        $connection->query($sql);
        $connection->query($sql2);

    }

?>
