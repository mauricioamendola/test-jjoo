<?php
include_once 'Participante.php';

class participantes{
	public $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($participante){
		$this-> coleccion[]=$participante;
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

	public function impactar(){
		//include_once '../../dbcfg.php';
		$dbuser = "toInsert";
		$dbpass = "toInsert";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } else {

			foreach ($this->coleccion as $fila){
				$connection->set_charset("utf8");
				echo "INSERT INTO participante VALUES(".$fila->GetId_Persona().",'','',".$fila->GetPrimer_Nombre()."','".$fila->GetPrimerApellido()."','',0)";
		        echo "<br>";
		        $sql1 = "INSERT INTO participante VALUES(".$fila->GetId_Persona().",'','',".$fila->GetPrimer_Nombre()."','".$fila->GetPrimerApellido()."','',0)";
		        $connection->set_charset("utf8");
		        $connection->query($sql1);

			}
		$connection->close();

		}
	}

	public function poblar(){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $deporte;

        $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            $sql = "SELECT pa.idpersona, apellidopersona, nombrepersona, sexo, nombrepais 
            FROM persona pe, participante pa, pais p
            WHERE pa.idpersona=pe.idpersona 
            AND pa.idpais=p.idpais  
            ORDER BY `apellidopersona` ASC";
            /*$query = $connection->query($sql);*/
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

		while ($row = $result->fetch_assoc()) {
			$participante = new Participante($row['idpersona'], $row['nombrepersona'], $row['apellidopersona'], $row['sexo'],'','','',$row['nombrepais'],'');
			$this->insertar($participante);
		}
		$connection->close();
	}





}