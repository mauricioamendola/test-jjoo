<?php

	class Pais {
		private $Id_Pais;
		private $Nombre_Pais;
		private $Codigo_Pais;

	public function __construct($Id_Pais,$Nombre_Pais,$Codigo_Pais){
		$this->Id_Pais=$Id_Pais;
		$this->Nombre_Pais=$Nombre_Pais;
		$this->Codigo_Pais=$Codigo_Pais;
	}

	public function GetId_Pais(){
		return $this->Id_Pais;
	}

	public function SetId_Pais($Id_Pais){
		$this->Id_Pais=$Id_Pais;
	}

	public function GetNombre_Pais(){
		return $this->Nombre_Pais;
	}

	public function SetNombre_Pais($Nombre_Pais){
		$this->Nombre_Pais=$Nombre_Pais;
	}

	public function GetCodigo_Pais(){
		return $this->Codigo_Pais;
	}

	public function SetCodigo_Pais($Codigo_Pais){
		$this->Codigo_Pais=$Codigo_Pais;
	}
}
?>
