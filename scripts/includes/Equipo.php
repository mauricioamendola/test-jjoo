<?php
include_once 'participantes.php';
include_once 'Categoria.php'; 

	class Equipo{
		private $Id_Equipo;
		private $Nombre_Equipo;
		public  $participantes;
		public  $Categoria;

	public function __construct($Id_Equipo,$Nombre_Equipo,$participantes,$Categoria){
		$this->Id_Equipo=$Id_Equipo;
		$this->Nombre_Equipo=$Nombre_Equipo;
		$this->participantes=$participantes;
		$this->Categoria=$Categoria;
	}	

	public function GetId_Equipo(){
		return $this->Id_Equipo;
	}

	public function SetId_Equipo($Id_Equipo){
		$this->Id_Equipo=$Id_Equipo;
	}

	public function GetNombre_Equipo(){
		return $this->Nombre_Equipo;
	}

	public function SetNombre_Equipo($Nombre_Equipo){
		$this->Nombre_Equipo=$Nombre_Equipo;
	}

	public function Getparticipantes(){
		return $this->participantes;
	}

	public function Setparticipantes($participantes){
		$this->participantes=$participantes;
	}

	public function GetCategoria(){
		return $this->Deportistas;
	}

	public function SetCategoria($Deportistas){
		$this->Deportistas=$Deportistas;
	}

	public function impactar(){
		$dbuser = "toInsert";
		$dbpass = "toInsert";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
		$connection->set_charset("utf8");
	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } 
	    else {
															
            $sql = "INSERT INTO equipo VALUES (0,".$this->Categoria.",'".$this->Nombre_Equipo."')";
			$result = $connection->query($sql) or die(mysqli_error($connection));
			$id = $connection->insert_id;
			for($i=0; $i<$this->participantes->largo(); $i++){
				
					$integrante = $this->participantes->getValor($i + 1);

					$sql2 = "INSERT INTO conforma VALUES ($id,".$integrante->GetId_Persona().")";
					$result2 = $connection->query($sql2) or die(mysqli_error($connection));
				}

		$connection->close();
		}	    	
	}

	public function update(){
		$dbuser = "toUpdate";
		$dbpass = "toUpdate";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
		$connection->set_charset("utf8");
	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } 
	    else {
															
            $sql = "UPDATE equipo  SET idcategoria=".$this->Categoria.",nombreequipo='".$this->Nombre_Equipo."' WHERE idequipo=".$this->Id_Equipo."";
			$result = $connection->query($sql) or die(mysqli_error($connection));
			$id = $this->Id_Equipo;
			$sql2 = "DELETE FROM CONFORMA WHERE idequipo=".$this->Id_Equipo."";
			$result2 = $connection->query($sql2) or die(mysqli_error($connection));

			for($i=0; $i<$this->participantes->largo(); $i++){
				
					$integrante = $this->participantes->getValor($i + 1);

					$sql3 = "INSERT INTO conforma VALUES ($id,".$integrante->GetId_Persona().")";
					$result3 = $connection->query($sql3) or die(mysqli_error($connection));
				}

		$connection->close();
		}	    	
	}

	public function delete(){
		$dbuser = "toDelete";
		$dbpass = "toDelete";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
		$connection->set_charset("utf8");
	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } 
	    else {
	    	$sql1="DELETE FROM conforma WHERE idequipo=".$this->Id_Equipo."";
	    	$result1 = $connection->query($sql1) or die(mysqli_error($connection));

	    	$sql2="DELETE FROM equipo WHERE idequipo=".$this->Id_Equipo."";
	    	$result2 = $connection->query($sql2) or die(mysqli_error($connection));
	    }
	    $connection->close();
	}
}
?>