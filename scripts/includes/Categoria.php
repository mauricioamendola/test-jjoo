<?php
	include_once 'Disciplina.php';
	class Categoria {
		private $Id_Categoria;
		private $Nombre_Categoria;
		private $Genero_Categoria;
		private $Descrip_Categoria;
		public $IdDisciplina;

	public function __construct($Id_Categoria,$Nombre_Categoria,$Genero_Categoria,$Descrip_Categoria,$IdDisciplina){
		$this->Id_Categoria=$Id_Categoria;
		$this->Nombre_Categoria=$Nombre_Categoria;
		$this->Genero_Categoria=$Genero_Categoria;
		$this->Descrip_Categoria=$Descrip_Categoria;
		$this->IdDisciplina=$IdDisciplina;
	}

	public function GetId_Categoria(){
		return $this->Id_Categoria;
	}

	public function SetId_Categoria($Id_Categoria){
		$this->Id_Categoria=$Id_Categoria;
	}

	public function GetNombre_Categoria(){
		return $this->Nombre_Categoria;
	}

	public function SetNombre_Categoria($Nombre_Categoria){
		$this->Nombre_Categoria=$Nombre_Categoria;
	}

	public function GetGenero_Categoria(){
		return $this->Genero_Categoria;
	}

	public function SetGenero_Categoria($Genero_Categoria){
		$this->Genero_Categoria=$Genero_Categoria;
	}
	public function GetDescrip_Categoria(){
		return $this->Descrip_Categoria;
	}

	public function SetDescrip_Categoria(){
		$this->Descrip_Categoria=$Descrip_Categoria;
	}

	public function GetId_Disciplina(){
		return $this->IdDisciplina;
	}

	public function SetId_Disciplina($IdDisciplina){
		$this->IdDisciplina=$IdDisciplina;
	}



}
?>
