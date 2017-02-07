<?php
include_once 'Persona.php';

	class Web extends Persona{
		Private $Nacionalidad;
		Private $Fecha_Nacimiento;

	public function __construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password,
	$Nacionalidad,$Fecha_Nacimiento){
	parent::__construct($Id_Persona,$Primer_Nombre,$Primer_Apellido,$Sexo,$Correo_Persona,$Nombre_Usuario,$Password);

		$this->Nacionalidad=$Nacionalidad;
		$this->Fecha_Nacimiento=$Fecha_Nacimiento;
	}

	Public function GetNacionalidad(){
		return $this->Nacionalidad;
	}

	Public function SetNacionalidad($Nacionalidad){
		$this->Nacionalidad=$Nacionalidad;
	}

	Public function GetFecha_Nacimiento(){
		return $this->Fecha_Nacimiento;
	}

	Public function SetFecha_Nacimiento($Fecha_Nacimiento){
		$this->Fecha_Nacimiento=$Fecha_Nacimiento;
	}

}
?>
