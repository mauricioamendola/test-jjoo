<?php
include_once 'Pais.php';
$path = dirname(dirname(__FILE__));
include_once $path.'/dbcfg.php';

class paises{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($pais){
		$this->coleccion[]=$pais;
	}

	public function getValor($posicion){
		return $this->coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return count($this->coleccion);
	}

	public function primero(){
		return $this->coleccion[$this -> largo()-1];
	}
	public function resto(){
		$this->coleccion[$this->largo()-1]=NULL;
	}

	public function esVacio(){
		if ($this->largo()==0){
			return true;
		}else{
			return false;
		}
	}

	public function poblar(){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $connection->set_charset("utf8");
            $sql = "SELECT IdPais, IdRegion, NombrePais, CodigoPais FROM pais";
            /*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
            $result = mysqli_query($connection, $sql);
            while($row = $result->fetch_assoc()){
				$pais = new Pais($row['IdPais'], $row['NombrePais'], $row['CodigoPais']);
				$this->insertar($pais);
			}
        }
	}

	public function poblarPorTorneo($torneo){
		$dbusername = "infoSelect";
		$dbpass = "infoselectpass";

		$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
		if ($connection->connect_error) {
			die("La conexiÃ³n a la base de datos ha fallado." . $connection->connect_error);
		} else {
			$connection->set_charset("utf8");
			$sql = "SELECT IdDelegacion, NombreDelegacion FROM delegacion WHERE IdTorneo=$torneo";
			/*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
			$result = mysqli_query($connection, $sql);
			while($row = $result->fetch_assoc()){
				//echo $row['IdDelegacion']. " - " . $row['NombreDelegacion'] . "<br>";
				$pais = new Pais($row['IdDelegacion'], $row['NombreDelegacion'], "");

				$this->insertar($pais);
			}
		}
	}
}
