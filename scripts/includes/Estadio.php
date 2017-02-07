<?php
include_once 'Lugar.php';


	class Estadio extends Lugar{
	private $Capacidad;

public function  __construct($Id_Lugar, $Nombre_Lugar, $Direccion_Lugar, $Latitud_lugar, $Longitud_Lugar, $Telefono_Lugar, $Web_Lugar, $Capacidad){
	$this->Capacidad=$Capacidad;
	parent::__Construct($Id_Lugar, $Nombre_Lugar, $Direccion_Lugar, $Latitud_lugar, $Longitud_Lugar, $Telefono_Lugar, $Web_Lugar);
}

public function GetCapacidad(){
	return $this->Capacidad;
}

public function SetCapacidad($Capacidad){
	$this->Capacidad=$Capacidad;
}

}
?>
