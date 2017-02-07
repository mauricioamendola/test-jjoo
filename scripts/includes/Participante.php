<?php
include_once 'Web.php';

	class Participante extends Web{

	public function __construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,
	$Nacionalidad,$Fecha_Nacimiento){
		parent::__construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,
	$Nacionalidad,$Fecha_Nacimiento);	
	}	

	public function delete(){
		$dbusername = "toDelete";
	    $dbpass = "toDelete";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			return 1;
	        } else {
	            mysqli_select_db($connection, DBNAME);
	            $sql = "DELETE FROM participante WHERE idpersona=".$this->Id_Persona.";";
	            echo $sql;
	            $result = $connection->query($sql);
	            //$result = mysqli_query($connection, $sql);
	            if (!$result) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
				return 0;
	        }
		}
	}
?>