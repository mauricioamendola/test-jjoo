<?php

	include_once 'participantes.php';
	include_once 'Pais.php';
	include_once 'Torneo.php';

	class Delegacion {
			Private $Id_Delegacion;
			Private $Nombre_Delegacion;
			Private $Torneo;
			Private $Pais;
			Private $participantes;

		public function __construct($Id_Delegacion,$Nombre_Delegacion,$Torneo,$Pais,$participantes){

				$this->Id_Delegacion=$Id_Delegacion;
				$this->Nombre_Delegacion=$Nombre_Delegacion;
				$this->Torneo=$Torneo;
				$this->Pais=$Pais;
				$this->participantes=$participantes;
		}

		public function GetId_Delegacion(){
			return $this->Id_Delegacion;
		}

		public function SetId_Delegacion($Id_Delegacion){
			$this->Id_Delegacion=$Id_Delegacion;
		}

		public function GetNombre_Delegacion(){
			return $this->Nombre_Delegacion;
		}

		public function SetNombre_Delegacion($Nombre_Delegacion){
			$this->Nombre_Delegacion=$Nombre_Delegacion;
		}

		public function GetTorneo(){
			return $this->Torneo;
		}

		public function SetTorneo($Torneo){
			$this->Torneo=$Torneo;
		}

		public function GetPais(){
			return $this->Pais;
		}

		public function SetPais($Pais){
			$this->Pais=$Pais;
		}

		public function GetParticipantes(){
			return $this->participantes;
		}

		public function SetParticipantes($participantes){
			$this->participantes=$participantes;
		}
	

		public function insertar_integrantes(){
			$dbuser = "toUpdate";
			$dbpass = "toUpdate";
			$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
			$connection->set_charset("utf8");
	    	if ($connection->connect_error) {
	        	die("La conexión a la base de datos ha fallado." . $connection->connect_error);
				$connection->close();
	    	} 
	    	else {
	    		$sql1 = "DELETE FROM Integra2 WHERE iddelegacion=".$this->Id_Delegacion."";
				$result1 = $connection->query($sql1) or die(mysqli_error($connection));

				for($i=0; $i<$this->participantes->largo(); $i++){
				
					$integrante = $this->participantes->getValor($i + 1);

					$sql2 = "INSERT INTO integra2 VALUES (".$integrante->GetId_Persona().",".$this->Id_Delegacion.")";
					$result2 = $connection->query($sql2) or die(mysqli_error($connection));
				}

			$connection->close();
	    	}
		}
	}
?>
