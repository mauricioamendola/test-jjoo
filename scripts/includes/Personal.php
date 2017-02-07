<?php
include_once 'Participante.php';

class Personal extends Participante{

	Private $Tipo;

	public function __construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,
	$Nacionalidad,$Fecha_Nacimiento,$Tipo){
		$this->Tipo=$Tipo;
		parent::__construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,
	$Nacionalidad,$Fecha_Nacimiento);
		
	}

	Public function GetTipo(){
		return $this->Tipo;
	}

	Public function SetTipo($Tipo){
		$this->Tipo=$Tipo;
	}

	Public function impactar(){
		//include_once '../../dbcfg.php';
		$dbuser = "toInsert";
		$dbpass = "toInsert";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
		$connection->set_charset("utf8");

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } else {
			
				echo "INSERT INTO Persona VALUES(".$this->GetId_Persona().",'','','".$this->GetPrimer_Nombre()."','".$this->GetPrimer_Apellido()."','',0,'".$this->GetSexo()."');";
		        echo "<br>";
		        $sql1 = "INSERT INTO Persona VALUES(".$this->GetId_Persona().",'','','".$this->GetPrimer_Nombre()."','".$this->GetPrimer_Apellido()."','',0,'".$this->GetSexo()."');";
		        $result1 = $connection->query($sql1);
		        if (!$result1) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }	
		        $id = $connection->insert_id;

		        echo "INSERT INTO Participante VALUES($id,'".$this->GetNacionalidad()."');";
		        echo "<br>";
		        
		        $sql2 = "INSERT INTO Participante VALUES($id,".$this->GetNacionalidad().");";
		        
		        echo "INSERT INTO Personal VALUES($id,'".$this->GetTipo()."')";
		        echo "<br>";
		        $sql2 .= "INSERT INTO Personal VALUES($id,'".$this->GetTipo()."')";
		        $result2 = $connection->multi_query($sql2);
		        if (!$result2) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }	
			}
	}

	Public function delete(){

			$dbusername = "toDelete";
	        $dbpass = "toDelete";

	        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	        mysqli_select_db($connection, DBNAME);
	        $connection->set_charset("utf8");

	        if ($connection->connect_error) {
	            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
				return 1;
	        } else {
	        	
				echo "DELETE FROM personal WHERE idpersona=".$this->GetId_Persona()."";
		        echo "<br>";
		        $sql1 = "DELETE FROM personal WHERE idpersona=".$this->GetId_Persona()."";

		        echo "DELETE FROM participante WHERE idpersona=".$this->GetId_Persona()."";
		        echo "<br>";	
		        $sql2 = "DELETE FROM participante WHERE idpersona=".$this->GetId_Persona()."";
		        
		        echo "DELETE FROM persona WHERE idpersona=".$this->GetId_Persona()."";
		        echo "<br>";
		        $sql3 = "DELETE FROM persona WHERE idpersona=".$this->GetId_Persona()."";
		        

		        $result1 = $connection->query($sql1);
		        if (!$result1) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
		        $result2 = $connection->query($sql2);
		        if (!$result2) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
		        $result3 = $connection->query($sql3);
		        if (!$result3) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
	            header("Location: ../cpanel/competitor.php?q=deleted");
	            
	    
	        }
	}

	Public function update(){

			$dbusername = "toUpdate";
	        $dbpass = "toUpdate";

	        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	        mysqli_select_db($connection, DBNAME);
	        $connection->set_charset("utf8");

	        if ($connection->connect_error) {
	            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
				return 1;
	        } else {
	        	
				echo "UPDATE personal SET tipopersonal = '".$this->GetTipo()."' WHERE idpersona=".$this->GetId_Persona()."";
		        echo "<br>";
		        $sql1 = "UPDATE personal SET tipopersonal = '".$this->GetTipo()."' WHERE idpersona=".$this->GetId_Persona()."";

		        
		        echo "SELECT idpais from pais WHERE nombrepais = '".$this->GetNacionalidad()."'";
		        echo "<br>";	
		        $sql2 ="SELECT idpais from pais WHERE nombrepais = '".$this->GetNacionalidad()."'";
		        $result2 =mysqli_query($connection, $sql2);
            	if (!$result2) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
            	}
            	while ($row = $result2->fetch_assoc()){
            		$idpais = $row['idpais'];
            	}

		        echo "UPDATE participante SET idpais=$idpais WHERE idpersona=".$this->GetId_Persona()."";
		        echo "<br>";
		        $sql3 = "UPDATE participante SET idpais=$idpais WHERE idpersona=".$this->GetId_Persona()."";
		        
		        echo "UPDATE persona SET nombrepersona='".$this->GetPrimer_Nombre()."', ApellidoPersona='".$this->GetPrimer_Apellido()."', sexo='".$this->GetSexo()."' WHERE idpersona=".$this->GetId_Persona()."";
		        echo "<br>";
		        $sql4 = "UPDATE persona SET nombrepersona='".$this->GetPrimer_Nombre()."', ApellidoPersona='".$this->GetPrimer_Apellido()."', sexo='".$this->GetSexo()."' WHERE idpersona=".$this->GetId_Persona()."";
		        

		        $result1 = $connection->query($sql1);
		        if (!$result1) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
		        $result3 = $connection->query($sql3);
		        if (!$result3) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
		        $result4 = $connection->query($sql4);
		        if (!$result4) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }    
	        }
	}
				
}

?>
