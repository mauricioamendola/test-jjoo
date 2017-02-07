<?php
include_once 'Lugar.php';
include_once 'Backends.php';

	class Oficina extends Lugar{
		public  $Backends;


	public function __construct($Id_Lugar,$Nombre_Lugar,$Direccion_Lugar,$Latitud_Lugar,$Longitud_Lugar,$Telefono_Lugar,$Web_Lugar,$Correo_Oficina,$Backends){
		$this->Backends=$Backends;
		parent::__construct($Id_Lugar,$Nombre_Lugar,$Direccion_Lugar,$Latitud_Lugar,$Longitud_Lugar,$Telefono_Lugar,$Web_Lugar);
	}	


	public function GetBackends(){
		return $this->Backends;
	}

	public function SetBackends($Backends){
		$this->Backends=$Backends;
	}

	
}
?>