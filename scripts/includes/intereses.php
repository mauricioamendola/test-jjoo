<?php
include_once 'interes.php';

class intereses{
	private $coleccion;

	public function __construct(){
		$this-> $coleccion=array();
	}

	public function insertar($interes){
		$this-> coleccion[]=$interes;
	}

	public function getValor($posicion){
		return $this-> coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return countarmamento($this-> coleccion);
	}

	public function primero(){
		return $this -> coleccion[$this -> largo()-1];
	}
	public function resto(){
		$this->coleccion[$this-> largo()-1]=NULL;
	}

	public function esVacio(){
		if ($this -> largo()==0){
			return true;
		}else{
			return false;
		}
	}






}