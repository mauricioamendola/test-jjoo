<?php
$path = dirname(dirname(__FILE__));
include_once $path.'/includes/Agenda.php';
include_once $path.'/dbcfg.php';

class agendas{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($agenda){
		$this->coleccion[]=$agenda;
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

	public function poblarPorId($id){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }
        else {
            $connection->set_charset("utf8");
            $sql = "SELECT IdActividad, NombreLugar, IdPersona, FechahoraActividad, TipoActividad, Observaciones FROM actividad a, lugar l WHERE a.idlugar=l.idlugar AND IdPersona=$id ORDER BY FechahoraActividad DESC";

            /*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
            $result = mysqli_query($connection, $sql);
            while($row=$result->fetch_assoc()){
            	$datetime = new DateTime($row['FechahoraActividad']);

				$date = $datetime->format('Y-m-d');
				$time = $datetime->format('H:i:s');
				//echo "".$row["IdPersona"].$row["NombrePersona"].$row["ApellidoPersona"]."";
				$agenda = new Agenda($row["IdActividad"], $row["NombreLugar"], $row["IdPersona"], $date, $time, $row['TipoActividad'], $row['Observaciones']);
				$this->insertar($agenda);
			}
        }
	}
}
