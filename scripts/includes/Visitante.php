<?php
include_once 'Web.php';

	class Visitante extends Web{
		public $Intereses

		public function __construct($Id_Persona,$Primer_Nombre,$Segundo_Nombre,$Primer_Apellido,$Segundo_Apellido,$Correo_Persona,$Nombre_Usuario,$Password,
	$Nacionalidad,$Fecha_Nacimiento, $Intereses){

			parent::__construct($Id_Persona,$Primer_Nombre,$Segundo_Nombre,$Primer_Apellido,$Segundo_Apellido,$Correo_Persona,$Nombre_Usuario,$Password,
			$Nacionalidad,$Fecha_Nacimiento);

			$this->Intereses=$Intereses;
		}

		public function GetIntereses(){
			return $this->Intereses;
		}

		public function SetIntereses($Intereses){
			$this->Intereses=$Intereses;
		}

}
?>