<?php
include_once 'Resultado.php';

class resultados{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($resultado){
		$this->coleccion[]=$resultado;
	}

	public function getValor($posicion){
		return $this-> coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return countarmamento($this->coleccion);
	}

	public function primero(){
		return $this->coleccion[$this -> largo()-1];
	}
	public function resto(){
		$this->coleccion[$this-> largo()-1]=NULL;
	}

	public function esVacio(){
		if ($this->largo()==0){
			return true;
		}else{
			return false;
		}
	}

	public function impactar($tipo){
		//include_once '../../dbcfg.php';
		$dbuser = "toInsert";
		$dbpass = "toInsert";
		$connection = new mysqli(DBSERV, $dbuser, $dbpass, DBNAME);
		$connection->set_charset("utf8");

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } 
	    else {
	    	if($tipo=='distancia'){

				foreach ($this->coleccion as $fila){
					echo $tipo;
					echo "INSERT INTO resultado VALUES(0,".$fila->GetEquipo().",'".$fila->GetNombre_Resultado()."','".$fila->GetTipo_Resultado()."','".$fila->GetNota()."',".$fila->GetFinal().")";
		        	echo "<br>";
		        	$sql = "INSERT INTO resultado VALUES(0,".$fila->GetEquipo().",'".$fila->GetNombre_Resultado()."','".$fila->GetTipo_Resultado()."','".$fila->GetNota()."',".$fila->GetFinal().")";
		        	$connection->query($sql);
		        	$id = $connection->insert_id;
		        	echo "INSERT INTO distancia VALUES($id,".$fila->GetPuntuacion().")";
		        	$sql2 = "INSERT INTO distancia VALUES($id,".$fila->GetPuntuacion().")";
		        	$connection->query($sql2);
		        }

			}elseif($tipo=='puntos'){

				foreach ($this->coleccion as $fila){
					echo $tipo;
					echo "INSERT INTO resultado VALUES(0,".$fila->GetEquipo().",'".$fila->GetNombre_Resultado()."','".$fila->GetTipo_Resultado()."','".$fila->GetNota()."',".$fila->GetFinal().")";
		        	echo "<br>";
		        	$sql = "INSERT INTO resultado VALUES(0,".$fila->GetEquipo().",'".$fila->GetNombre_Resultado()."','".$fila->GetTipo_Resultado()."','".$fila->GetNota()."',".$fila->GetFinal().")";
		        	$connection->query($sql);
		        	$id = $connection->insert_id;
		        	echo "INSERT INTO puntos VALUES($id,".$fila->GetPuntuacion().")";
		        	$sql2 = "INSERT INTO puntos VALUES($id,".$fila->GetPuntuacion().")";
		        	$connection->query($sql2);
		        }

		    }elseif($tipo=='tiempo'){

		    	foreach ($this->coleccion as $fila){
					echo $tipo;
					echo "INSERT INTO resultado VALUES(0,".$fila->GetEquipo().",'".$fila->GetNombre_Resultado()."','".$fila->GetTipo_Resultado()."','".$fila->GetNota()."',".$fila->GetFinal().")";
		        	echo "<br>";
		        	$sql = "INSERT INTO resultado VALUES(0,".$fila->GetEquipo().",'".$fila->GetNombre_Resultado()."','".$fila->GetTipo_Resultado()."','".$fila->GetNota()."',".$fila->GetFinal().")";
		        	$connection->query($sql);
		        	$id = $connection->insert_id;
		        	$tiempo = array();
		        	$i=0;
		        	foreach($fila->GetPuntuacion() as $puntuacion){
		        		$tiempo[$i]=$puntuacion;
		        		$i++; 
		        	}
		        	echo "INSERT INTO tiempo VALUES($id,".$tiempo[0].",".$tiempo[1].",".$tiempo[2].",".$tiempo[3].")";
		        	$sql2 = "INSERT INTO tiempo VALUES($id,".$tiempo[0].",".$tiempo[1].",".$tiempo[2].",".$tiempo[3].")";
		        	$connection->query($sql2);
		        	print_r($tiempo);  		
		        }	
		    }

			$connection->close();
		}
	}




}