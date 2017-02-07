<?php
    session_start();
    include_once("dbcfg.php");
    include_once('includes/region.php');

            $Reg=strtolower($_REQUEST['regionName']);
            $continente = new Region($_REQUEST['regionName']);
            $servname = "localhost";
            $dbuser = "toInsert";
            $dbpass = "toInsert";
            $connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
            if ($connection->connect_error) {
                die("La conexión a la base de datos ha fallado." . $connection->connect_error);
            }

           
            $connection->set_charset("utf8");
            
            $sql ="SELECT nombreRegion from region where lower(nombreRegion)='$Reg'";
            $consulta=$connection->query($sql);
            $row=mysqli_num_rows($consulta);  

            if($row == 0)
            {
                
                echo "INSERT INTO region VALUES(0,'".$continente->GetNombreRegion()."')";
                echo "<br>";
                $sql = "INSERT INTO region(nombreRegion) VALUES('".$continente->GetNombreRegion()."')";
                $connection->query($sql);
                $connection->close();
                header("Location: ../cpanel/countries.php?q=add");
            }
            else
            {
                $connection->close();
                header("Location: ../cpanel/addregion.php?q=existeregion");
                }
        

       
?>
