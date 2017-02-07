<?php
	Include_once 'Delegacion.php';
	Include_once 'Equipo.php';
	Include_once 'Evento.php';
	Include_once 'Deportista.php';
	Include_once 'Categoria.php';


	class Interes{
	
	Private $Id_Interes;
	Public $Delegacion;
	Public $Equipo;
	Public $Evento;
	Public $Deportista;
	Public $Categoria;


	Public function__Construct($Id_Interes,$Delegacion,$Equipo,$Evento,$Deportista,$Categoria){
		$this->Id_Interes=$Id_Interes;
		$this->Delegacion=$Delegacion;
		$this->Equipo=$Equipo;
		$this->Evento=$Evento;
		$this->Deportista=$Deportista;
		$this->Categoria=$Categoria;
		}	

	public function GetId_Interes(){
			return $this->Id_Interes;
	}

	public function SetId_Interes($Id_Interes){
			$this->Id_Interes=$Id_Interes;
	}


	public function GetDelegacion(){
			return $this->Delegacion;
	}

	public function SetDelegacion($Delegacion){
			$this->Delegacion=$Delegacion;
	}


	public function GetEquipo(){
			return $this->Equipo;
	}

	public function SetEquipo($Equipo){
			$this->Equipo=$Equipo;
	}


	public function GetEvento(){
			return $this->Evento;
	}

	public function SetEvento($Evento){
			$this->Evento=$Evento;
	}


	public function GetDeportista(){
			return $this->Deportista;
	}

	public function SetDeportista($Deportista){
			$this->Deportista=$Deportista;
	}

	public function GetCategoria(){
			return $this->Categoria;
	}

	public function SetCategoria($Categoria){
			$this->Categoria=$Categoria;
	}
}
?>
