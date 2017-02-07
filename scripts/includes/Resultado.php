<?php
	include_once 'Equipo.php';
	
	class Resultado{

		private $Nombre_Resultado;
		private $Tipo_Resultado;
		private $Nota;
		private $Final;
		private $Puntuacion;
		private $Equipo;
		

	public function __construct($Nombre_Resultado,$Tipo_Resultado,$Nota,$Final,$Puntuacion,$Equipo){
		$this->Nombre_Resultado=$Nombre_Resultado;
		$this->Tipo_Resultado=$Tipo_Resultado;
		$this->Nota=$Nota;
		$this->Final=$Final;
		$this->Puntuacion=$Puntuacion;
		$this->Equipo=$Equipo;
		

	}	

	public function GetNombre_Resultado(){
		return $this->Nombre_Resultado;
	}	

	public function SetNombre_Resultado($Nombre_Resultado){
		$this->Nombre_Resultado=$Nombre_Resultado;
	}	

	public function GetTipo_Resultado(){
		return $this->Tipo_Resultado;
	}	

	public function SetTipo_Resultado($Tipo_Resultado){
		$this->Tipo_Resultado=$Tipo_Resultado;
	}	

	public function GetNota(){
		return $this->Nota;
	}	

	public function SetNota($Nota){
		$this->Nota=$Nota;
	}	

	public function GetFinal(){
		return $this->Final;
	}	

	public function SetFinal($Final){
		$this->Final=$Final;
	}	

	public function GetPuntuacion(){
		return $this->Puntuacion;
	}	

	public function SetPuntuacion($Puntuacion){
		$this->Puntuacion=$Puntuacion;
	}	

	public function GetEquipo(){
		return $this->Equipo;
	}

	public function SetEquipo($Equipo){
		$this->Equipo=$Equipo;
	}

}
?>
