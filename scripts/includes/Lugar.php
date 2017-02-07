<?php
	$path = dirname(dirname(__FILE__));
	include_once $path."/dbcfg.php";

	class Lugar{
		private $Id_Lugar;
		private $Nombre_Lugar;
		private $Direccion_Lugar;
		private $Latitud_Lugar;
		private $Longitud_Lugar;
		private $Web_Lugar;
		private $Id_Sede;
		private $Tipo_Servicio;

	public function __construct($Id_Lugar, $Id_Sede, $Tipo_Servicio, $Nombre_Lugar, $Direccion_Lugar, $Web_Lugar, $Latitud_Lugar, $Longitud_Lugar){
		$this->Id_Lugar=$Id_Lugar;
		$this->Id_Sede=$Id_Sede;
		$this->Tipo_Servicio=$Tipo_Servicio;
		$this->Nombre_Lugar=$Nombre_Lugar;
		$this->Direccion_Lugar=$Direccion_Lugar;
		$this->Web_Lugar=$Web_Lugar;
		$this->Latitud_Lugar=$Latitud_Lugar;
		$this->Longitud_Lugar=$Longitud_Lugar;
	}

	public function GetId_Lugar(){
		return $this->Id_Lugar;
	}

	public function SetId_Lugar($Id_Lugar){
		$this->Id_Lugar=$Id_Lugar;
	}

	public function GetNombre_Lugar(){
		return $this->Nombre_Lugar;
	}

	public function SetNombre_Lugar($Nombre_Lugar){
		 $this->Nombre_Lugar=$Nombre_Lugar;
	}

	public function GetDireccion_Lugar(){
		return $this->Direccion_Lugar;
	}

	public function SetDireccion_Lugar($Direccion_Lugar){
		$this->Direccion_Lugar=$Direccion_Lugar;
	}

	public function GetLatitud_Lugar(){
		return $this->Latitud_Lugar;
	}

	public function SetLatitud_Lugar($Latitud_Lugar){
		$this->Latitud_Lugar=$Latitud_Lugar;
	}

	Public function GetLongitud_Lugar(){
		return $this->Longitud_Lugar;
	}

	public function SetLongitud_Lugar($Longitud_Lugar){
		$this->Longitud_Lugar=$Longitud_Lugar;
	}

	public function GetTelefono_Lugar(){
		return $this->Telefono_Lugar;
	}

	public function SetTelefono_Lugar($Longitud_Lugar){
		$this->Longitud_Lugar=$Longitud_Lugar;
	}

	public function GetWeb_Lugar(){
		return $this->Web_Lugar;
	}

	public function SetWeb_Lugar($Web_Lugar){
		$this->Id_Sede=$Web_Lugar;
	}

	public function GetId_Sede(){
		return $this->Id_Sede;
	}

	public function SetId_Sede($Id_Sede){
		$this->Id_Sede=$Id_Sede;
	}

	public function GetTipo_Servicio(){
		return $this->Tipo_Servicio;
	}

	public function SetTipo_Servicio($Tipo_Servicio){
		$this->Tipo_Servicio=$Tipo_Servicio;
	}

	public function insertLugar(){
		$dbuser = "toInsert";
        $dbpass = "toInsert";

        $conexion = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

        if ($conexion->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
			$conexion->set_charset("utf8");
            $sql = "INSERT INTO lugar VALUES (0, 1, '$this->Nombre_Lugar', '$this->Direccion_Lugar', '$this->Web_Lugar', '$this->Latitud_Lugar', '$this->Longitud_Lugar');";
			$res = $conexion->query($sql) or die(mysqli_error($conexion));
			$id = $conexion->insert_id;
            $conexion->close();

			$conexion2 = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

	        if ($conexion2->connect_error) {
	            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
	        } else {
				$conexion2->set_charset("utf8");
	            if ($this->Tipo_Servicio != "estadio"){
					$sql = "INSERT INTO servicio VALUES ($id, '$this->Tipo_Servicio');";
				}
	            $res = $conexion2->query($sql) or die(mysqli_error($conexion2));
	            $conexion2->close();
	        }
        }
		header("Location: ../cpanel/places.php?q=addSuccess");
	}

	public function update(){
		$dbuser = "toUpdate";
        $dbpass = "toUpdate";

        $conexion = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

		if ($conexion->connect_error) {
			die("La conexión con la base de datos ha fallado. " . $conexion->connect_error);
		} else {
			$sql = "UPDATE lugar SET NombreLugar='$this->Nombre_Lugar', DireccionLugar='$this->Direccion_Lugar', SitiowebLugar='$this->Web_Lugar', LatitudLugar='$this->Latitud_Lugar', LongitudLugar='$this->Longitud_Lugar' WHERE IdLugar=$this->Id_Lugar";
			if (!$conexion->query($sql)){
				die("No se ha podido actualizar los datos en la tabla " . DBSERV . ".'lugar'. Error de MySQL: " . mysqli_error($conexion));
			} else {
				$sql = "UPDATE servicio SET TipoServicio='$this->Tipo_Servicio' WHERE IdLugar=$this->Id_Lugar";
				if (!$conexion->query($sql)){
					die("No se han podido actualizar los datos en la tabla " . DBSERV . ".'servicios'. Error de MySQL: " . $conexion->connect_error);
				}
			}
			header("Location: ../cpanel/places.php?q=updateSuccess");
		}
	}

	public function delete(){
		$dbuser = "toDelete";
        $dbpass = "toDelete";

        $conexion = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

		if ($conexion->connect_error) {
			die("La conexión con la base de datos ha fallado. " . $conexion->connect_error);
		} else {
			$sql = "DELETE FROM lugar WHERE IdLugar=$this->Id_Lugar";
			if (!$conexion->query($sql)){
				die("No se ha podido eliminar los datos. Error de MySQL: " . mysqli_error($conexion));
			}
		}
	}

}
?>
