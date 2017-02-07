<?php
    session_start();
    include_once("dbcfg.php");
    include_once('includes/disciplinas.php');

    $Nameminus = strtolower($_REQUEST['sportName']);
    $deporte = new Disciplina(0, $_REQUEST['sportName'], $_REQUEST['sportDescription'], $_REQUEST['sportRegulation'], $_REQUEST['sportHistory']);
    $lista = new disciplinas();

    $dbuser = "toInsert";
    $dbpass = "toInsert";

    $selectuser = "infoSelect";
    $selectpass = "infoselectpass";
    $coneccion = new mysqli(DBSERV, $selectuser, $selectpass, DBNAME);

    if ($coneccion->connect_error) {
        die("La conexión a la base de datos ha fallado." . $coneccion->connect_error);
    }

    $coneccion->set_charset("utf8");

    $sql ="SELECT NombreDisciplina from disciplina where lower(nombreDisciplina)='$Nameminus'";
            $consulta=$coneccion->query($sql);
            $row=mysqli_num_rows($consulta);  

    if($row == 0)
    {

        $lista->insertar($deporte);
        $lista->impactar();

        echo "SELECT IdDisciplina FROM disciplina WHERE NombreDisciplina='".$_REQUEST['sportName']."'";
        echo "<br>";

        $sqlid = "SELECT IdDisciplina FROM disciplina WHERE NombreDisciplina='".$_REQUEST['sportName']."'";

        $result = mysqli_query($coneccion, $sqlid);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($coneccion));
            exit();
        }

        while ($row = $result->fetch_assoc()) {
            $sportid = $row['IdDisciplina'];
        }

        echo "<pre>";
        print_r(var_dump($_FILES));
        echo "Hola\n";
        print_r(var_dump($_FILES["sportPic"]["name"]));
        echo "Hola2\n";
        echo "</pre>";
        if (isset($_FILES["sportPic"]["name"])) {

            $name = $sportid.".png";
            $tmp_name = $_FILES['sportPic']['tmp_name'];
            $error = $_FILES['sportPic']['error'];

            if (!empty($name)) {
                $location = '../img/sport-icon/';
                if(file_exists($location.$name)){
                    unlink($location.$name);
                }else{
                    if  (move_uploaded_file($tmp_name, $location.$name)){
                        echo 'Uploaded';
                    }
                }

            } else {
                echo 'please choose a file';
            }
        } else {
            echo "Error al subir archivo";
        }
        header("Location: ../cpanel/sports.php?q=add");
    }
    else
    {
        $coneccion->close();
        header("Location: ../cpanel/addsport.php?q=existedeporte");
    }
?>
