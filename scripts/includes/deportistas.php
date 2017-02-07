<?php
include_once 'Deportista.php';
$path = dirname(dirname(__FILE__));
include_once $path.'/dbcfg.php';

class deportistas{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($deportista){
		$this->coleccion[]=$deportista;
	}

	public function getValor($posicion){
		return $this->coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return count($this->coleccion);
	}

	public function primero(){
		return $this->coleccion[$this -> largo()-1];
	}
	public function resto(){
		$this->coleccion[$this-> largo()-1]=NULL;
	}

	public function esVacio(){
		if ($this -> largo()==0){
			return true;
		}else{
			return false;
		}
	}

	public function impactar(){

		$dbuser = "toInsert";
		$dbpass = "toInsert";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
		$connection->set_charset("utf8");
	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } else {

			foreach ($this->coleccion as $fila){
				echo "INSERT INTO Persona VALUES(0,'','','".$fila->GetPrimer_Nombre()."','".$fila->GetPrimer_Apellido()."','',0,'".$fila->GetSexo()."')";
		        echo "<br>";
		       	$sql1 = "INSERT INTO Persona VALUES(0,'','','".$fila->GetPrimer_Nombre()."','".$fila->GetPrimer_Apellido()."','',0,'".$fila->GetSexo()."')";
		       	$result1 = $connection->query($sql1);
		        if (!$result1) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
		        $id = $connection->insert_id;

		        echo "INSERT INTO Participante VALUES($id,'".$fila->GetNacionalidad()."');";
		        echo "<br>";	
		        $sql2 = "INSERT INTO Participante VALUES($id,'".$fila->GetNacionalidad()."');";
		        
		        echo "INSERT INTO Deportista VALUES($id,".$fila->GetAltura().",".$fila->GetPeso().")";
		        echo "<br>";
		        $sql2 .= "INSERT INTO Deportista VALUES($id,".$fila->GetAltura().",".$fila->GetPeso().")";
		        $result2 = $connection->multi_query($sql2);;
		        if (!$result2) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }	
			}

		}

	}

	public function poblarPorPais($idPais){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $connection->set_charset("utf8");
            $sql = "SELECT p1.IdPersona, NombrePersona, ApellidoPersona FROM persona p1 LEFT JOIN participante p2 ON p1.IdPersona = p2.IdPersona WHERE p2.IdPais=$idPais";
            /*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
            $result = mysqli_query($connection, $sql);
            while($row = $result->fetch_assoc()){
				$deportista = new Persona($row["IdPersona"], $row["NombrePersona"], $row["ApellidoPersona"], "", "", "");
				$this->insertar($deportista);
			}
        }
	}

	public function poblarPorDelegacion($id){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $connection->set_charset("utf8");
            $sql = "SELECT NombreDisciplina, R.NombrePersona, R.ApellidoPersona, R.IdPersona
					from Disciplina H, Categoria C, Equipo E, Conforma F, Deportista X, Participante P, Delegacion T, Persona R, Integra2 Z
					Where E.IdEquipo=F.IdEquipo
					And C.IdCategoria=E.IdCategoria
					And H.IdDisciplina=C.IdDisciplina
					And P.IdPersona=F.IdPersona
					And P.IdPersona=X.IdPersona
					And R.IdPersona=P.IdPersona
					And P.IdPersona=Z.IdPersona
					And T.IdDelegacion=Z.IdDelegacion
					And Z.IdDelegacion=$id Group by NombrePersona, ApellidoPersona";

            /*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
            $result = mysqli_query($connection, $sql);
            while($row=$result->fetch_assoc()){
				$deportista = new Deportista($row["IdPersona"], $row["NombrePersona"], $row["ApellidoPersona"], "", "", "", "", "", "", "", "", "");
				$this->insertar($deportista);
			}
        }
	}

	public function poblarPorDisciplina($did, $sid){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } 
        else {
            $connection->set_charset("utf8");
            $sql = "SELECT NombreDisciplina, R.NombrePersona, R.ApellidoPersona, R.IdPersona
					from Disciplina H, Categoria C, Equipo E, Conforma F, Deportista X, Participante P, Delegacion T, Persona R, Integra2 Z
					Where E.IdEquipo=F.IdEquipo
					And C.IdCategoria=E.IdCategoria
					And H.IdDisciplina=C.IdDisciplina
					And P.IdPersona=F.IdPersona
					And P.IdPersona=X.IdPersona
					And R.IdPersona=P.IdPersona
					And P.IdPersona=Z.IdPersona
					And T.IdDelegacion=Z.IdDelegacion
					And Z.IdDelegacion=$did
					And H.IdDisciplina=$sid Group by NombrePersona, ApellidoPersona";

            /*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
            $result = mysqli_query($connection, $sql);
            while($row=$result->fetch_assoc()){
				
				$deportista = new Deportista($row["IdPersona"], $row["NombrePersona"], $row["ApellidoPersona"], "", "", "", "", "", "", "", "");
				$this->insertar($deportista);
			}
			
        }
    }
    public function delete(){

		$dbusername = "toDelete";
	    $dbpass = "toDelete";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	    mysqli_select_db($connection, DBNAME);
	    $connection->set_charset("utf8");

	        if ($connection->connect_error) {
	            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
				return 1;
	        } 
	        else {
	        	foreach ($this->coleccion as $fila){

					echo "DELETE FROM deportista WHERE idpersona=".$fila->GetId_Persona()."";
		        	echo "<br>";
		        	$sql1 = "DELETE FROM deportista WHERE idpersona=".$fila->GetId_Persona()."";

		        	echo "DELETE FROM participante WHERE idpersona=".$fila->GetId_Persona()."";
		        	echo "<br>";	
		        	$sql2 = "DELETE FROM participante WHERE idpersona=".$fila->GetId_Persona()."";
		        
		        	echo "DELETE FROM persona WHERE idpersona=".$fila->GetId_Persona()."";
		        	echo "<br>";
		        	$sql3 = "DELETE FROM persona WHERE idpersona=".$fila->GetId_Persona()."";
		        

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
	            }
	        	header("Location: ../cpanel/competitor.php?q=deleted");
	        }
	}

	public function update(){
			$dbusername = "toUpdate";
	        $dbpass = "toUpdate";

	        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	        mysqli_select_db($connection, DBNAME);
	        $connection->set_charset("utf8");

	        if ($connection->connect_error) {
	            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
				return 1;
	        } else {
	        	foreach ($this->coleccion as $fila){

					echo "UPDATE deportista SET alturadeportista = '".$fila->GetAltura()."', pesodeportista = '".$fila->GetPeso()."' WHERE idpersona=".$fila->GetId_Persona()."";
		        	echo "<br>";
		        	$sql1 = "UPDATE deportista SET alturadeportista = '".$fila->GetAltura()."', pesodeportista = '".$fila->GetPeso()."' WHERE idpersona=".$fila->GetId_Persona()."";

		        
		        	echo "SELECT idpais from pais WHERE nombrepais = '".$fila->GetNacionalidad()."'";
		        	echo "<br>";	
		        	$sql2 ="SELECT idpais from pais WHERE nombrepais = '".$fila->GetNacionalidad()."'";
		        	$result2 =mysqli_query($connection, $sql2);
            		if (!$result2) {
	                	printf("Error: %s\n", mysqli_error($connection));
	                	exit();
            		}
            		while ($row = $result2->fetch_assoc()){
            			$idpais = $row['idpais'];
            		}

		        	echo "UPDATE participante SET idpais=$idpais WHERE idpersona=".$fila->GetId_Persona()."";
		        	echo "<br>";

		        	$sql3 = "UPDATE participante SET idpais=$idpais WHERE idpersona=".$fila->GetId_Persona()."";
		        

		        	echo "UPDATE persona SET nombrepersona='".$fila->GetPrimer_Nombre()."', apellidopersona='".$fila->GetPrimer_Apellido()."', sexo='".$fila->GetSexo()."' WHERE idpersona=".$fila->GetId_Persona()."";
		        	echo "<br>";
		        	$sql4 = "UPDATE persona SET nombrepersona='".$fila->GetPrimer_Nombre()."', apellidopersona='".$fila->GetPrimer_Apellido()."', sexo='".$fila->GetSexo()."' WHERE idpersona=".$fila->GetId_Persona()."";
		        

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
	        $connection->close();
	        }
	}
}
