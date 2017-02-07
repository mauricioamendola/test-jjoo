<?php

	include_once 'Participante.php';

	class Deportista extends Participante {
			Private $Peso;
			Private $Altura;

		public function __construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,$Nacionalidad,$Fecha_Nacimiento,$Peso,$Altura){
				parent::__construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,$Nacionalidad,$Fecha_Nacimiento);
				$this->Peso=$Peso;
				$this->Altura=$Altura;
			}

		public function GetPeso(){
			return $this->Peso;
		}

		public function SetPeso($Peso){
			$this->Peso=$Peso;
		}

		public function GetAltura(){
			return $this->Altura;
		}

		public function SetAltura($Altura){
			$this->Altura=$Altura;
		}
	}
?>
