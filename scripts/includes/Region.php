<?php

include_once 'Paises.php';

	class Region{
		private $Nombre_Region;
		public  $Paises;

	public function __construct($NombreRegion,$Paises){
	
		$this->NombreRegion=$NombreRegion;
		$this->Paises=$Paises;
	}	

	public function GetNombreRegion(){
		return $this->NombreRegion;
	}

	public function SetNombreRegion($NombreRegion){
		$this->NombreRegion=$NombreRegion;
	}

	public function GetPaises(){
		return $this->Paises;
	}

	public function SetPaises($Paises){
		$this->Paises=$Paises;
	}
	
	}
?>