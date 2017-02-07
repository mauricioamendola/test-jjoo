<?php

	class Disciplina{
		private $Id_Disciplina;
		private $Nombre_Disciplina;
		private $Descrip_Disciplina;
		private $Reg_Disciplina;
		private $Hist_Disciplina;

		public function __construct($Id_Disciplina,$Nombre_Disciplina,$Descrip_Disciplina,$Reg_Disciplina,$Hist_Disciplina){
			$this->Id_Disciplina=$Id_Disciplina;
			$this->Nombre_Disciplina=$Nombre_Disciplina;
			$this->Descrip_Disciplina=$Descrip_Disciplina;
			$this->Reg_Disciplina=$Reg_Disciplina;
			$this->Hist_Disciplina=$Hist_Disciplina;

		}
		public function GetId_Disciplina(){
			return $this->Id_Disciplina;
		}

		public function SetId_Disciplina($Id_Disciplina){
			$this->Id_Disciplina=$Id_Disciplina;
		}

		public function GetNombre_Disciplina(){
			return $this->Nombre_Disciplina;
		}

		public function SetNombre_Disciplina($Nombre_Disciplina){
			$this->Nombre_Disciplina=$Nombre_Disciplina;
		}

		public function GetDescrip_Disciplina(){
			return $this->Descrip_Disciplina;
		}

		public function SetDescrip_Disciplina($Descrip_Disciplina){
			$this->Descrip_Disciplina=$Descrip_Disciplina;
		}

		public function GetReg_Disciplina(){
			return $this->Reg_Disciplina;
		}

		public function SetReg_Disciplina($Reg_Disciplina){
			$this->Reg_Disciplina=$Reg_Disciplina;
		}

		public function GetHist_Disciplina(){
			return $this->Hist_Disciplina;
		}

		public function SetHist_Disciplina($Hist_Disciplina){
			$this->Hist_Disciplina=$Hist_Disciplina;
		}

		public function delete(){
			$dbusername = "toDelete";
	        $dbpass = "toDelete";

	        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);

	        if ($connection->connect_error) {
	            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
				return 1;
	        } else {
	            mysqli_select_db($connection, DBNAME);
	            $sql = "DELETE FROM disciplina WHERE iddisciplina=".$this->Id_Disciplina.";";
	            echo $sql;
	            $result = $connection->query($sql);
	            //$result = mysqli_query($connection, $sql);
	            if (!$result) {
	                printf("Error: %s\n", mysqli_error($connection));
	                exit();
	            }
				return 0;
	        }
		}

	}

?>
