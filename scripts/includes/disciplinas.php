<?php
$path = dirname(dirname(__FILE__));
include_once 'Disciplina.php';
include_once $path.'/dbcfg.php';


class disciplinas{
	public $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($disciplina){
		$this->coleccion[]=$disciplina;
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
				echo "INSERT INTO disciplina VALUES(".$fila->GetId_Disciplina().",'".$fila->GetNombre_Disciplina()."','".$fila->GetDescrip_Disciplina()."','".$fila->GetReg_Disciplina()."','".$fila->GetHist_Disciplina()."')";
		        echo "<br>";
		        $sql = "INSERT INTO disciplina VALUES(".$fila->GetId_Disciplina().",'".$fila->GetNombre_Disciplina()."','".$fila->GetDescrip_Disciplina()."','".$fila->GetReg_Disciplina()."','".$fila->GetHist_Disciplina()."')";
		        $connection->set_charset("utf8");
		        /*$query = $connection->query($sql);*/
		        $connection->query($sql);

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
            $sql = "SELECT iddisciplina, nombredisciplina, descripciondisciplina FROM disciplina ORDER BY nombredisciplina";
            /*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

		while ($row = $result->fetch_assoc()) {
			$deporte = new Disciplina($row['iddisciplina'], $row['nombredisciplina'], $row['descripciondisciplina'],'','');
			$this->insertar($deporte);
		}
		$connection->close();
	}

	public function poblarPorPais($cid){
		$dbusername = "infoSelect";
		$dbpass = "infoselectpass";
		$deporte;

		$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
		if ($connection->connect_error) {
			die("La conexión a la base de datos ha fallado." . $connection->connect_error);
		} else {
			$sql = "SELECT NombreDisciplina, H.IdDisciplina 
					FROM Disciplina H, Categoria C, Equipo E, Conforma F, Participante P, Delegacion T, Integra2 Z 
					Where E.IdEquipo=F.IdEquipo 
					And C.IdCategoria=E.IdCategoria 
					And H.IdDisciplina=C.IdDisciplina 
					And P.IdPersona=F.IdPersona  
					And P.IdPersona=Z.IdPersona 
					And T.IdDelegacion=Z.IdDelegacion 
					And Z.IdDelegacion=$cid Group by NombreDisciplina";
			/*$query = $connection->query($sql);*/
			$connection->set_charset("utf8");
			$result = mysqli_query($connection, $sql);
			if (!$result) {
				printf("Error: %s\n", mysqli_error($connection));
				exit();
			}
		}

		while ($row = $result->fetch_assoc()) {
			$deporte = new Disciplina($row['IdDisciplina'], $row['NombreDisciplina'], "","","");
			$this->insertar($deporte);
		}
		$connection->close();
	}

}
