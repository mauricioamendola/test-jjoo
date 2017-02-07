<?php

	Class Comodidad{
		
		private $Id_Comodidad;
		private $Nombre_Comodidad;
		private $Descrip_Comodidad;

	public function __construct($Id_Comodidad,$Nombre_Comodidad,$Descrip_Comodidad){
		$this->Id_Comodidad=$Id_Comodidad;
		$this->Nombre_Comodidad=$Nombre_Comodidad;
		$this->Descrip_Comodidad=$Descrip_Comodidad;
	}	

	public function GetId_Comodidad(){
		return $this->Id_Comodidad;
	}

	public function SetId_Comodidad($Id_Comodidad){
		$this->Id_Comodidad=$Id_Comodidad;
	}

	public function GetNombre_Comodidad(){
		return $this->Nombre_Comodidad;
	}

	public function SetNombre_Comodidad($Nombre_Comodidad){
		$this->Nombre_Comodidad=$Nombre_Comodidad;
	}

	public function GetDescrip_Comodidad(){
		return $this->Descrip_Comodidad;
	}

	public function SetDescrip_Comodidad($Descrip_Comodidad){
		$this->Descrip_Comodidad=$Descrip_Comodidad;
	}
}
?>