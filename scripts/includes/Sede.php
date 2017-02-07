<?php
	include_once 'Lugares.php';

	class Sede{

		private $Id_Sede;
		private $Nombre_Sede;
		private $Latitud_Sede;
		private $Longitud_Sede;
		public $Lugares;

	public function __construct($Id_Sede,$Nombre_Sede,$Latitud_Sede,$Longitud_Sede,$Lugares){
		$this->Id_Sede=$Id_Sede;
		$this->Nombre_Sede=$Nombre_Sede;
		$this->Longitud_Sede=$Longitud_Sede;
		$this->Latitud_Sede=$Latitud_Sede;
		$this->Lugares=$Lugares;
		
	}	

	public function GetId_Sede(){
		return $this->Id_Sede;
	}

	public function SetId_Sede($Id_Sede){
		$this->Id_Sede=$Id_Sede;
	}

	public function GetNombre_Sede(){
		return $this->Nombre_Sede;
	}

	public function SetNombre_Sede($Nombre_Sede){
		$this->Nombre_Sede=$Nombre_Sede;
	}

	public function GetLongitud_Sede(){
		return $this->Longitud_Sede;
	}

	public function SetLongitud_Sede($Longitud_Sede){
		$this->Longitud_Sede=$Longitud_Sede;
	}

	public function GetLatitud_Sede(){
		return $this->Latitud_Sede;
	}

	public function SetLatitud_Sede($Latitud_Sede){
		$this->Latitud_Sede=$Latitud_Sede;
	}

	public function GetLugares(){
		return $this->Lugares;
	}

	public function SetLugares($Lugares){
		$this->Lugares=$Lugares;
	}

}

?>