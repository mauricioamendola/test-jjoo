<?php
	
	Class Fase{
		Private $Id_Fase;
		Private $Nombre_Fase;
		Private $Tipo_Fase;
		Private $Id_Torneo;
		
	public function __construct($Id_Fase,$Nombre_Fase,$Tipo_Fase,$Id_Torneo){
		$this->Id_Fase=$Id_Fase;
		$this->Nombre_Fase=$Nombre_Fase;
		$this->Tipo_Fase=$Tipo_Fase;
		$this->Id_Torneo=$Id_Torneo;	
	}	

	public function GetId_Fase(){
		return $this->Id_Fase;
	}

	public function SetId_Fase($Id_Fase){
		$this->Id_Fase=$Id_Fase;
	}

	public function GetNombre_Fase(){
		return $this->Nombre_Fase;
	}

	public function SetNombre_Fase($Nombre_Fase){
		$this->Nombre_Fase=$Nombre_Fase;
	}

	public function GetTipo_Fase(){
		return $this->Tipo_Fase;
	}

	public function SetTipo_Fase($Tipo_Fase){
		$this->Tipo_Fase=$Tipo_Fase;
	}

	public function GetId_Torneo(){
		return $this->Id_Torneo;
	}

	public function SetId_Torneo($Id_Torneo){
		$this->Id_Torneo=$Id_Torneo;
	}
	
}
?>