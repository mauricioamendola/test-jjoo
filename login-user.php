<?php
    include_once "scripts/dbcfg.php";
    ob_start();
    session_start();

    $dbusername = "infoSelect";
    $dbpass = "infoselectpass";


    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBSEC);

    if ($connection->connect_error) {
        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
    } else {
        $sql = "SELECT u.NombreUsuario, PassUsuario, IdRol FROM Usuario u, UsuarioOcupaRol r  WHERE u.NombreUsuario='" . $_REQUEST['username'] . "' AND u.NombreUsuario=r.NombreUsuario;";

        mysqli_set_charset($connection, "utf8");
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
        }
        $row = $result->fetch_assoc();
            if (password_verify($_REQUEST['password'], $row['PassUsuario']) && ($_REQUEST['username']== $row['NombreUsuario'])){ // compara las passwords
                $user[] = array("valid" => "true","rol" => $row['IdRol']);
                $_SESSION['username']=$_REQUEST['username'];
                $_SESSION['password']=$_REQUEST['password'];
                $_SESSION['logged']='true';
                $_SESSION['rol']=$row['IdRol'];
                if($row['IdRol']=='3'){
                    $_SESSION['cpanel']='true';    
                }else{
                    $_SESSION['cpanel']='false';
                }
                echo json_encode($user);
                //print_r($user);
            } else {
                $user[] = array("valid" => "false");
                echo json_encode($user);
                //print_r($user);
            }
        //}
    }
    $connection->close();
?>
