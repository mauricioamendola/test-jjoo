<?php
include_once 'Lugar.php';
include_once 'Comodidades.php';

	class Servicio extends Lugar{
		private $Tipo_Servicio;
		public $Comodidades;

	public function__construct($Id_Lugar,$Nombre_Lugar,$Direccion_Lugar,$Latitud_Lugar,$Longitud_Lugar,$Telefono_Lugar,$Web_Lugar,$Tipo_Servicio,$Comodidades){
	parent::__Construct($Id_Lugar,$Nombre_Lugar,$Direccion_Lugar,$Latitud_Lugar,$Longitud_Lugar,$Telefono_Lugar,$Web_Lugar);
		$this->Tipo_Servicio=$Tipo_Servicio;
		$this->Comodidades=$Comodidades;
	}	

	public function GetTipo_Servicio(){
		return $this->Tipo_Servicio;
	}

	public function SetTipo_Servicio($Tipo_Servicio){
		$this->Tipo_Servicio=$Tipo_Servicio;
	}

	public function GetComodidades(){
		return $this->Comodidades;
	}

	public function SetComodidades($Comodidades){
		$this->Comodidades=$Comodidades;
	}
}
?>