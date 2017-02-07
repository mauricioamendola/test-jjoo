<?php
$path = dirname(dirname(__FILE__));
include_once 'Lugar.php';
include_once $path.'/conexion.php';
include_once $path.'/dbcfg.php';

class lugares{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($lugar){
		$this-> coleccion[]=$lugar;
	}

	public function getValor($posicion){
		return $this-> coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return count($this-> coleccion);
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

	public function poblarLugares(){
		$dbusername = "infoSelect";
		$dbpass = "infoselectpass";
		$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
		$connection->set_charset("utf8");
		$consulta = "SELECT l.IdLugar, IdSede, s.TipoServicio, NombreLugar, DireccionLugar, SitiowebLugar, LatitudLugar, LongitudLugar FROM lugar l LEFT JOIN servicio s ON l.IdLugar = s.IdLugar";
		$resultado = mysqli_query($connection, $consulta);

		while($row = $resultado->fetch_assoc()){
			if ($row['TipoServicio'] === NULL){
				$lugar = new Lugar($row['IdLugar'], $row['IdSede'], 'estadio', $row['NombreLugar'], $row['DireccionLugar'], $row['SitiowebLugar'], $row['LatitudLugar'], $row['LongitudLugar']);
			}
			else $lugar = new Lugar($row['IdLugar'], $row['IdSede'], $row['TipoServicio'], $row['NombreLugar'], $row['DireccionLugar'], $row['SitiowebLugar'], $row['LatitudLugar'], $row['LongitudLugar']);
			$this->insertar($lugar);
		}
	}

	public function poblarLugaresFiltro($filtro){
		$dbusername = "infoSelect";
		$dbpass = "infoselectpass";
		$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
		$connection->set_charset("utf8");

		if ($filtro == 'todos'){
			$consulta = "SELECT l.IdLugar, IdSede, s.TipoServicio, NombreLugar, DireccionLugar, SitiowebLugar, LatitudLugar, LongitudLugar FROM lugar l LEFT JOIN servicio s ON l.IdLugar = s.IdLugar";
			$resultado = mysqli_query($connection, $consulta);

			while($row = $resultado->fetch_assoc()){
				if ($row['TipoServicio'] === NULL){
					$lugar = new Lugar($row['IdLugar'], $row['IdSede'], 'estadio', $row['NombreLugar'], $row['DireccionLugar'], $row['SitiowebLugar'], $row['LatitudLugar'], $row['LongitudLugar']);
				}
				else $lugar = new Lugar($row['IdLugar'], $row['IdSede'], $row['TipoServicio'], $row['NombreLugar'], $row['DireccionLugar'], $row['SitiowebLugar'], $row['LatitudLugar'], $row['LongitudLugar']);
				$this->insertar($lugar);
			}

	    }elseif ($filtro == 'estadio'){
	        $consulta = "SELECT I.IdLugar, IdSede, NombreLugar, DireccionLugar, SitiowebLugar, LatitudLugar, LongitudLugar
	        			FROM Lugar L, Instalacion I
	                    WHERE L.IdLugar = I.IdLugar";
	        $resultado = mysqli_query($connection, $consulta);
	        while($row = $resultado->fetch_assoc()){
				$lugar = new Lugar($row['IdLugar'], $row['IdSede'], 'estadio', $row['NombreLugar'], $row['DireccionLugar'], $row['SitiowebLugar'], $row['LatitudLugar'], $row['LongitudLugar']);
				$this->insertar($lugar);
			}
	    } else {
	        	$consulta1 = "SELECT s.IdLugar, IdSede, s.TipoServicio, NombreLugar, DireccionLugar, SitiowebLugar, LatitudLugar, LongitudLugar
	                    FROM lugar l, servicio s
	                    WHERE l.IdLugar = s.IdLugar AND s.TipoServicio='$filtro'";
	            $resultado1 = mysqli_query($connection, $consulta1);

				while($row = $resultado1->fetch_assoc()){
					 $lugar = new Lugar($row['IdLugar'], $row['IdSede'], $row['TipoServicio'], $row['NombreLugar'], $row['DireccionLugar'], $row['SitiowebLugar'], $row['LatitudLugar'], $row['LongitudLugar']);
					$this->insertar($lugar);
				}
			}
		}

		public function poblarLugaresPorTipo($tipo){
			$dbusername = "infoSelect";
			$dbpass = "infoselectpass";
			$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
			$connection->set_charset("utf8");

			if($tipo=="estadio"){
				$sql = "SELECT DISTINCT l.IdLugar, l.NombreLugar FROM lugar l, servicio s WHERE l.IdLugar<>s.IdLugar";
			} else {
				$sql = "SELECT l.IdLugar, l.NombreLugar FROM lugar l, servicio s WHERE l.IdLugar=s.IdLugar AND s.TipoServicio='$tipo'";
			}
			$resultado = mysqli_query($connection, $sql);

			while($row = $resultado->fetch_assoc()){
				$lugar = new Lugar($row['IdLugar'], "", "", $row['NombreLugar'], "", "", "", "");
				$this->insertar($lugar);
			}
		}
}
