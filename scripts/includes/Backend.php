<?php
include_once 'Persona.php';

	class Backend extends Persona{
		private $Tipo;

	Public function __construct($Id_Persona,$Primer_Nombre,$Segundo_Nombre,$Primer_Apellido,$Segundo_Apellido,$Correo_Persona,$Nombre_Usuario,$Password,$Tipo){
	$this->Tipo=$Tipo;
	parent::__Construct($Id_Persona,$Primer_Nombre,$Segundo_Nombre,$Primer_Apellido,$Segundo_Apellido,$Correo_Persona,$Nombre_Usuario,$Password);		
	}
	
	public function GetTipo(){
		return $this->Tipo;
	}

	public function SetTipo(Tipo){
		$this->Tipo=$Tipo;
	}	
}
?>
