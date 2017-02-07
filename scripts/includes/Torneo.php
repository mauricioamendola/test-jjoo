<?php
	class Torneo{
		private $Id_Torneo;
		private $Nombre_Torneo;
		private $Descrip_Fecha;


	public function __construct($Id_Torneo,$Nombre_Torneo,$Fecha_Torneo){
		$this->Id_Torneo=$Id_Torneo;
		$this->Nombre_Torneo=$Nombre_Torneo;
		$this->Fecha_Torneo=$Fecha_Torneo;
	}
	public function GetId_Torneo(){
		return $this->Id_Torneo;
	}

	public function SetId_Torneo($Id_Torneo){
		$this->Id_Torneo=$Id_Torneo;
	}

	public function GetNombre_Torneo(){
		return $this->Nombre_Torneo;
	}

	public function SetNombre_Torneo($Nombre_Torneo){
		$this->Nombre_Torneo=$Nombre_Torneo;
	}

	public function GetFecha_Torneo(){
		return $this->Descrip_Torneo;
	}

	public function SetFecha_Torneo($Fecha_Torneo){
		$this->Fecha_Torneo=$Fecha_Torneo;
	}
	public function Insert_Torneo($nombre,$fecha,$usuario){

		$servname = "localhost";
		$connection = new mysqli(DBSERV, "toInsert", "toInsert", DBNAME);

		$year=substr($fecha,0,4);
		if ($connection->connect_error) {
			die("La conexión a la base de datos ha fallado." . $connection->connect_error);
		}
		else {
        $sql = "INSERT INTO torneo VALUES(0, '".$nombre."','".$year."')";
        /*$query = $connection->query($sql);*/
		$res = $connection->query($sql) or die(mysqli_error($connection));
        //$connection->query($sql);
        $connection->close();
		}
	}

	public function Delete_Torneo($id,$usuario){

		$servname = "localhost";
		$connection = new mysqli(DBSERV, $usuario, "", DBNAME);

		if ($connection->connect_error) {
			die("La conexión a la base de datos ha fallado." . $connection->connect_error);
		}
		else {
        mysqli_select_db($connection, "olympicinfoapp");
        $sql = "DELETE FROM torneo WHERE IdTorneo='".$id."'";
        /*$query = $connection->query($sql);*/
        $connection->query($sql);
        $connection->close();
		}
	}

	public function Select_Torneo($usuario){

		$servname = "localhost";
		$connection = new mysqli($servname, $usuario, "", "olympicinfoapp");

		if ($connection->connect_error) {
			die("La conexión a la base de datos ha fallado." . $connection->connect_error);
		}
		else {
        mysqli_select_db($connection, "olympicinfoapp");
        $sql = "SELECT IdTorneo as Id, NombreTorneo as Nombre, FechaTorneo as Año FROM torneo";
        /*$query = $connection->query($sql);*/
        $connection->query($sql);
        $connection->close();
		}
	}
}
?>
