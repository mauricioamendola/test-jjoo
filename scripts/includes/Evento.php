<?php
include_once 'equipos.php';


	Class Evento {

		private $Id_Evento;
		private $Nombre_Evento;
		private $Categoria_Evento;
		private $FechaHora_Evento;
		private $Lugar_Evento;
		private $Estado_Evento;
		private $Equipos;

	public function __construct($Id_Evento,$Nombre_Evento,$Categoria_Evento,$FechaHora_Evento,$Lugar_Evento,$Estado_Evento,$Equipos){
		
		$this->Id_Evento=$Id_Evento;
		$this->Nombre_Evento=$Nombre_Evento;
		$this->Categoria_Evento=$Categoria_Evento;
		$this->FechaHora_Evento=$FechaHora_Evento;
		$this->Lugar_Evento=$Lugar_Evento;
		$this->Estado_Evento=$Estado_Evento;
		$this->Equipos=$Equipos;
		
		}

	public function GetId_Evento(){
		return $this->Id_Evento;
	}

	public function SetId_Evento($Id_Evento){
		$this->Id_Evento=$Id_Evento;
	}

	public function GetNombre_Evento(){
		return $this->Nombre_Evento;
	}

	public function SetNombre_Evento($Nombre_Evento){
		$this->Nombre_Evento=$Nombre_Evento;
	}

	public function GetFechaHora_Evento(){
		return $this->FechaHora_Evento;
	}

	public function SetFechaHora_Evento($FechaHora_Evento){
		$this->FechaHora_Evento=$FechaHora_Evento;
	}

	public function GetLugar_Evento(){
		return $this->Lugar_Evento;
	}

	public function SetLugar_Evento($Lugar_Evento){
		$this->Lugar_Evento=$Lugar_Evento;
	}

	public function GetEstado_Evento(){
		return $this->Estado_Evento;
	}

	public function SetEstado_Evento($Estado_Evento){
		$this->Estado_Evento=$Estado_Evento;
	}


	public function GetCategoria_Evento(){
		return $this->Categoria_Evento;
	}

	public function SetCategoria_Evento($Categoria_Evento){
		$this->Categoria_Evento=$Categoria_Evento;
	}

	public function GetEquipos(){
		return $this->Equipos;
	}

	public function SetEquipos($Equipos){
		$this->Equipos=$Equipos;
	}


}
?>
