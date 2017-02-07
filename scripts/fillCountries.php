<?php
    //session_start();
    include_once("../scripts/dbcfg.php");


    function getCountriesList(){
        //$servname = "localhost";
        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $regionid = $_REQUEST["regionid"];

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT idpais, nombrepais FROM pais WHERE idregion=".$regionid." ORDER BY nombrepais";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        //echo "<select class='selectpicker' id='pais'>";
        echo "<option selected='selected'>Seleccionar un país</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['idpais']."'>".$row['nombrepais']."</option>";
        }

        //echo "</select>";
    }

    function getCountriesTable($id){

        $dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            //mysqli_select_db($connection, DBNAME);
            mysqli_set_charset($connection, "utf-8");

            if($id=='undefined'){
                $sql = "SELECT idpais, nombrepais, codigopais FROM pais ORDER BY nombrepais";
            }else{
                $sql = "SELECT idpais, nombrepais, codigopais FROM pais where idregion=$id ORDER BY nombrepais";
            }
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        $newHtml = "";

        while ($row = $result->fetch_assoc()) {
            /*echo "<tr>";
            echo "<td>".$row['idpais']."</td>";
            echo "<td>".$row['nombrepais']."</td>";
            echo "<td><button type='button' class='btn btn-link btn-xs' onclick=location.href='modcountry.php?id=".$row['idpais']."&name=".$row['nombrepais']."'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";
            echo "<td><button type='button' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspSeleccionar</button></td>";
            echo "</tr>";*/

            $countryName = utf8_encode($row['nombrepais']);
            $codigo= utf8_encode($row['codigopais']);
            $pais = urlencode($row['nombrepais']);
            $uri = "modcountry.php?id=".$row['idpais']."&name=".$pais."";
            //echo "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>";

            $newHtml =  $newHtml .
                        "<tr>" .
                        "<td>".$row['idpais']."</td>" .
                        "<td>".$countryName."</td>" .
                        "<td>".$codigo."</td>" .
                        "<td><button type='button' class='btn btn-link btn-xs' onclick='location.href=\"".$uri."\"'><span class='glyphicon glyphicon-pencil'></span>&nbsp&nbsp&nbspModificar</button></td>" .
                        "<td><button type='button' class='btn btn-link btn-xs' onclick='confirmDeleteCountry(".$row['idpais'].")'><text class='text-danger'><span class='glyphicon glyphicon-trash'></span>&nbsp&nbsp&nbspEliminar</text></button></td>" .
                        "</tr>";
        }
        echo $newHtml;
    }

    function insertCountry($region, $name, $iso){


            $Isomayus=strtoupper($iso);
            $Nameminus=strtolower($name);
            $dbuser = "toInsert";
            $dbpass = "toInsert";
            $connection = new mysqli(DBSERV, $dbuser, $dbpass);

            if ($connection->connect_error) {
                die("La conexión a la base de datos ha fallado." . $connection->connect_error);
            }

            mysqli_select_db($connection, DBNAME);
            $connection->set_charset("utf8");
            $sql1 ="SELECT Nombrepais from pais where lower(NombrePais)='$Nameminus'";
            $consulta1=$connection->query($sql1);
            $row1=mysqli_num_rows($consulta1);

            mysqli_select_db($connection, DBNAME);
            $sql2 ="SELECT CodigoPais from pais where upper(CodigoPais)='$Isomayus'";
            $consulta2=$connection->query($sql2);
            $row2=mysqli_num_rows($consulta2);

            if($row1 != 0)
            {
                $connection->close();
                header("Location: ../cpanel/addcountry.php?q=existepais");
            }
            elseif($row2 != 0)
            {
                $connection->close();
                header("Location: ../cpanel/addcountry.php?q=existeiso");
            }
            else
            {
                echo "INSERT INTO pais VALUES(0,'$region', '$name', '$Isomayus')";
                echo "<br>";
                $sql = "INSERT INTO pais VALUES(0,'$region', '$name', '$Isomayus')";
                /*$query = $connection->query($sql);*/
                $connection->query($sql);
                $connection->close();
                header("Location: ../cpanel/countries.php?q=addpais");
            }


    }

    function updateCountry($id, $region, $name, $iso){
        $dbuser = "toUpdate";
        $dbpass = "toUpdate";

        echo "entro en funcion<br>";

        $update = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

        if ($update->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            echo "entro en sql<br>";
            mysqli_select_db($update, DBNAME);
            $update->set_charset("utf8");
            $sql = "UPDATE pais set IdRegion='$region', NombrePais='$name', CodigoPais='$iso' WHERE IdPais=".intval($id)."";
            echo $sql."<br>";
            /*$query = $connection->query($sql);*/
            $res = $update->query($sql) or die(mysqli_error($update));
            $update->close();
        }
        header("Location: ../cpanel/countries.php?q=updatepais");
    }

    function deleteCountry($id){
        $dbusername = "toDelete";
        $dbpass = "toDelete";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);
        echo "entro en funcion <br>";

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "DELETE FROM pais WHERE idpais=".$id.";";
            echo $sql;
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
            header("Location: ../cpanel/countries.php?q=deleteSuccesspais");
        }
    }

    function poblarPorTorneo($id){
        include_once "includes/paises.php";

        $lista = new paises();
        $lista->poblarPorTorneo($id);
        $largo = $lista->largo();
        for ($i=1; $i<=$largo; $i++){
            echo "<option value='".$lista->getValor($i)->GetId_Pais()."'>".$lista->getValor($i)->GetNombre_Pais()."</option>";
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    // De acá para abajo se manejan los casos en los que se llama el archivo. //
    ////////////////////////////////////////////////////////////////////////////

    /*if (isset($_REQUEST['regionid']) and $_REQUEST['regionid'] != "NO_ID") {
        getCountriesTable($_REQUEST['regionid']);
    }*/

    if(isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case "selectCountry":
                getCountriesTable($_REQUEST['regionid']);
                break;
            case "addCountry":
                insertCountry($_REQUEST['region'], $_REQUEST['countryName'], $_REQUEST['countryIso']);
                break;
            case "updateCountry":
                updateCountry($_REQUEST['countryId'], $_REQUEST['region'], utf8_encode($_REQUEST['countryName']), $_REQUEST['countryIso']);
                break;
            case "deleteCountry":
                deleteCountry($_REQUEST['id']);
                break;
            case "selectCountryTourny":
                poblarPorTorneo($_REQUEST['tournyid']);
                break;
        }
    }

?>
