<?php
	include_once 'Deportista.php'

	class Historial{
		private $Id_Historial;
		private $Tipo_Historial;
		private $Fecha_Historial;
		private $Puntuacion;
		private $Posicion;
		public $Deportista

	public function __construct($Id_Historial,$Tipo_Historial,$Fecha_Historial,$Puntuacion,$Posicion,$Deportista){
		$this->Id_Historial=$Id_Historial;
		$this->Tipo_Historial=$Tipo_Historial;
		$this->Fecha_Historial=$Fecha_Historial;
		$this->Puntuacion=$Puntuacion;
		$this->Posicion=$Posicion;
		$this->Deportista=$Deportista;	
	}	

	public function GetId_Historial(){
		return $this->Id_Historial;
	}

	public function SetId_Historial($Id_Historial){
		$this->Id_Historial=$Id_Historial;
	}

	public function GetId_Historial(){
		return $this->Id_Historial;
	}

	public function SetId_Historial($Id_Historial){
		$this->Id_Historial=$Id_Historial;
	}

	public function GetTipo_Historial(){
		return $this->Tipo_Historial;
	}

	public function SetTipo_Historial($Tipo_Historial){
		$this->Tipo_Historial=$Tipo_Historial;
	}

	public function GetFecha_Historial(){
		return $this->Fecha_Historial;
	}

	public function SetFecha_Historial($Fecha_Historial){
		$this->Fecha_Historial=$Fecha_Historial;
	}

	public function GetPuntuacion(){
		return $this->Puntuacion;
	}

	public function SetPuntuacion($Puntuacion){
		$this->Puntuacion=$Puntuacion;
	}

	public function GetPosicion(){
		return $this->Posicion;
	}

	public function SetPosicion($Posicion){
		$this->Posicion=$Posicion;
	}

	public function GetDeportista(){
		return $this->Deportista;
	}

	public function SetDeportista($Deportista){
		$this->Deportista=$Deportista;
	}
}
?>




