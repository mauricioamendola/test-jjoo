<?php
include_once 'Fase.php';

class fases{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($fase){
		$this-> coleccion[]=$fase;
	}

	public function getValor($posicion){
		return $this-> coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return count($this-> coleccion);
	}

	public function primero(){
		return $this -> coleccion[$this -> largo()-1];
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
				
				echo "INSERT INTO competencia VALUES(".$fila->GetId_Fase().",".$fila->GetId_Torneo().",'".$fila->GetNombre_Fase()."','".$fila->GetTipo_Fase()."')";
		        echo "<br>";
		        $sql = "INSERT INTO competencia VALUES(".$fila->GetId_Fase().",".$fila->GetId_Torneo().",'".$fila->GetNombre_Fase()."','".$fila->GetTipo_Fase()."')";
		      
		        $connection->query($sql);

			}
		$connection->close();

		}
	}

	public function delete(){
		$dbusername = "toDelete";
	    $dbpass = "toDelete";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	    mysqli_select_db($connection, DBNAME);

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	        } 
	        else {

	            foreach ($this->coleccion as $fila){

	            	$sql = "DELETE FROM competencia WHERE idcompetencia = ".$fila->GetId_Fase()."";
	            	echo $sql;
	            	$result = $connection->query($sql);
	            	$connection->close();	
				}
	      	}
	}

	public function actualizar(){
		$dbusername = "toUpdate";
	    $dbpass = "toUpdate";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	    mysqli_select_db($connection, DBNAME);
	    $connection->set_charset("utf8");

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	        } 
	        else {

	            foreach ($this->coleccion as $fila){

	            	$sql = "UPDATE competencia SET NombreCompetencia='".$fila->GetNombre_Fase()."', IdTorneo=".$fila->GetId_Torneo().", TipoCompetencia='".$fila->GetTipo_Fase()."' WHERE IdCompetencia = ".$fila->GetId_Fase()."";
	            	echo $sql;
	            	$result = $connection->query($sql);
	            	$connection->close();	
				}
	      	}
	}				
	
}