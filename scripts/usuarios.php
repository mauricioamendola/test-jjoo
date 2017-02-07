<?php
    include_once "./dbcfg.php";

    function rolOp($username){
        $array = array(
        "GRANT ALL ON TABLE olympicapp.actividad TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.caracteristica TO '$username'",
        "GRANT ALL ON TABLE olympicapp.categoria TO '$username'",
        "GRANT ALL ON TABLE olympicapp.competencia TO '$username'",
        "GRANT ALL ON TABLE olympicapp.competidor TO '$username'",
        "GRANT ALL ON TABLE olympicapp.conforma TO '$username'",
        "GRANT ALL ON TABLE olympicapp.delegacion TO '$username'",
        "GRANT ALL ON TABLE olympicapp.deportista TO '$username'",
        "GRANT ALL ON TABLE olympicapp.disciplina TO '$username'",
        "GRANT ALL ON TABLE olympicapp.distancia TO '$username'",
        "GRANT ALL ON TABLE olympicapp.equipo TO '$username'",
        "GRANT ALL ON TABLE olympicapp.evento TO '$username'",
        "GRANT ALL ON TABLE olympicapp.historico TO '$username'",
        "GRANT ALL ON TABLE olympicapp.instalacion TO '$username'",
        "GRANT ALL ON TABLE olympicapp.integra TO '$username'",
        "GRANT ALL ON TABLE olympicapp.integra2 TO '$username'",
        "GRANT ALL ON TABLE olympicapp.lugar TO '$username'",
        "GRANT ALL ON TABLE olympicapp.pais TO '$username'",
        "GRANT ALL ON TABLE olympicapp.participante TO '$username'",
        "GRANT ALL ON TABLE olympicapp.persona TO '$username'",
        "GRANT ALL ON TABLE olympicapp.personal TO '$username'",
        "GRANT ALL ON TABLE olympicapp.puntos TO '$username'",
        "GRANT ALL ON TABLE olympicapp.region TO '$username'",
        "GRANT ALL ON TABLE olympicapp.resultado TO '$username'",
        "GRANT ALL ON TABLE olympicapp.servicio TO '$username'",
        "GRANT ALL ON TABLE olympicapp.telefono TO '$username'",
        "GRANT ALL ON TABLE olympicapp.tiempo TO '$username'",
        "GRANT ALL ON TABLE olympicapp.tiene TO '$username'",
        "GRANT ALL ON TABLE olympicapp.torneo TO '$username'"
        );
        return $array;
    }

    function rolDep($username){
        $array = array(
        "GRANT SELECT ON TABLE olympicapp.actividad TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.categoria TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.competencia TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.competidor TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.conforma TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.delegacion TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.deportista TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.disciplina TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.distancia TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.equipo TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.evento TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.historico TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.instalacion TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.integra TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.integra2 TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.lugar TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.pais TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.participante TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.persona TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.personal TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.puntos TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.region TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.resultado TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.servicio TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.telefono TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.tiempo TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.tiene TO '$username'",
        "GRANT SELECT ON TABLE olympicapp.torneo TO '$username'"
        );
        return $array;
    }

    function rolAdm($username){
        $array = array(
        "GRANT ALL ON TABLE olympicapp.actividad TO '$username'",
		"GRANT ALL ON TABLE olympicapp.categoria TO '$username'",
		"GRANT ALL ON TABLE olympicapp.auditoria TO '$username'",
		"GRANT ALL ON TABLE olympicapp.caracteristica TO '$username'",
		"GRANT ALL ON TABLE olympicapp.competencia TO '$username'",
		"GRANT ALL ON TABLE olympicapp.competidor TO '$username'",
		"GRANT ALL ON TABLE olympicapp.conforma TO '$username'",
		"GRANT ALL ON TABLE olympicapp.delegacion TO '$username'",
		"GRANT ALL ON TABLE olympicapp.deportista TO '$username'",
		"GRANT ALL ON TABLE olympicapp.disciplina TO '$username'",
		"GRANT ALL ON TABLE olympicapp.distancia TO '$username'",
		"GRANT ALL ON TABLE olympicapp.equipo TO '$username'",
		"GRANT ALL ON TABLE olympicapp.evento TO '$username'",
		"GRANT ALL ON TABLE olympicapp.historico TO '$username'",
		"GRANT ALL ON TABLE olympicapp.instalacion TO '$username'",
		"GRANT ALL ON TABLE olympicapp.integra TO '$username'",
		"GRANT ALL ON TABLE olympicapp.integra2 TO '$username'",
		"GRANT ALL ON TABLE olympicapp.lugar TO '$username'",
		"GRANT ALL ON TABLE olympicapp.pais TO '$username'",
		"GRANT ALL ON TABLE olympicapp.participante TO '$username'",
		"GRANT ALL ON TABLE olympicapp.persona TO '$username'",
		"GRANT ALL ON TABLE olympicapp.personal TO '$username'",
		"GRANT ALL ON TABLE olympicapp.puntos TO '$username'",
		"GRANT ALL ON TABLE olympicapp.region TO '$username'",
		"GRANT ALL ON TABLE olympicapp.resultado TO '$username'",
		"GRANT ALL ON TABLE olympicapp.servicio TO '$username'",
		"GRANT ALL ON TABLE olympicapp.telefono TO '$username'",
		"GRANT ALL ON TABLE olympicapp.tiempo TO '$username'",
		"GRANT ALL ON TABLE olympicapp.tiene TO '$username'",
		"GRANT ALL ON TABLE olympicapp.torneo TO '$username'
        ");

        return $array;
    }

    function createUser($username, $pass, $mail, $rol, $idpersona){
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $state = 0;

        switch($rol){
            case 1:
                $grant = rolOp($username);
                break;
            case 2:
                $grant = rolDep($username);
                break;
            case 3:
                $grant = rolAdm($username);
                break;
        }

        $dbuser = "createUser";
        $dbpass = "usercreator";

        $dbuser2 = "toUpdate";;
        $dbpass2 = "toUpdate";;

        $connection = new mysqli(DBSERV, $dbuser, $dbpass, DBSEC);
        $connection2 = new mysqli(DBSERV, $dbuser2, $dbpass2, DBNAME); 

        if ($connection->connect_error) {
            echo "error";
        } else {
            $sqlUser = "INSERT INTO usuario VALUES(?, ?)";
            $sqlRol = "INSERT INTO usuarioocuparol VALUES(?,?)";
            
            $sentencia1 = $connection->prepare($sqlUser);
            
            $sentencia1->bind_param("ss", $username, $password);
            $sentencia1->execute(); 

            $sentencia2 = $connection->prepare($sqlRol);
            $sentencia2->bind_param("si", $username, $rol);
            $sentencia2->execute();

            if ($rol == 2){
                $sqldata = "UPDATE persona SET nombreusuario=?, correopersona=? WHERE idpersona=$idpersona";
                $sentencia3 = $connection2->prepare($sqldata);
                $sentencia3->bind_param("ss", $username, $mail);
                $sentencia3->execute();
            } 

            $userCreate = "CREATE USER '" . $username . "'@'localhost' IDENTIFIED BY '" . $pass . "';";


            if(!$connection->query($userCreate)){
                printf("Error de Creacion: %s\n", $connection->connect_error);
            } 

            for($i=0; $i<count($grant);$i++){
                $cadena = $grant[$i];
                if(!$connection->query($cadena)){
                    echo $connection->error;
                }
            }
            $sentencia1->close();
            $sentencia2->close();
            $sentencia3->close();
            $connection->close();
            $connection2->close();
            echo "ok";
        }
    }

    if(isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case "addUser":
                createUser($_REQUEST['user'], $_REQUEST['pass'], $_REQUEST['mail'], $_REQUEST['rol'], $_REQUEST['id']);
                break;
        }
    }
?>
