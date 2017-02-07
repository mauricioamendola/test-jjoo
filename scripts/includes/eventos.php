<?php
include_once 'Evento.php';

class eventos{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($evento){
		$this->coleccion[]=$evento;
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
	
	public function poblarFechas($idtorneo){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT DISTINCT FechahoraEvento FROM evento WHERE IdTorneo=$idtorneo ORDER BY FechahoraEvento ASC";
            
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        if(mysqli_num_rows($result)==0){
            echo "<p style='text-align: center; font-style: italic;'>No se han encontrado eventos para el torneo seleccionado.</p>";
        }

		$fechas = array();

        while ($row = $result->fetch_assoc()) {
			$fechas[] = $row['FechahoraEvento'];
        }
		return $fechas;
	}

	public function poblarPorFecha($dia, $mes, $año, $idtorneo){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdEvento, NombreEvento, d.NombreDisciplina, c.NombreCategoria, c.Genero, l.NombreLugar, FechahoraEvento, EstadoEvento
					FROM evento e, lugar l, disciplina d, categoria c
					WHERE IdTorneo=$idtorneo
						AND l.IdLugar=e.IdLugar
						AND d.IdDisciplina = c.IdDisciplina
						AND e.IdCategoria = c.IdCategoria
						AND YEAR(FechahoraEvento)=$año
						AND MONTH(FechahoraEvento)=$mes
						AND DAY(FechahoraEvento)=$dia
					GROUP BY e.IdCategoria";
            
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        if(mysqli_num_rows($result)==0){
            echo "<p style='text-align: center; font-style: italic;'>No se han encontrado eventos para la fecha.</p>";
        }

        while ($row = $result->fetch_assoc()) {
			$id = $row['IdEvento'];
			$nombre = $row['NombreEvento'];
			$disciplina = $row['NombreDisciplina'];
			$categoria = $row['NombreCategoria'];
			$genero = $row['Genero'];
			$lugar = $row['NombreLugar'];
			$fechaHora = $row['FechahoraEvento'];
			$estado = $row['EstadoEvento'];

			$evento = new Evento($id, $nombre, $disciplina, $categoria, $genero, $fechaHora, $lugar, $estado);
			$this->insertar($evento);
        }
	}
	
	public function poblarPorId($id){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT NombreEvento, CONCAT(d.NombreDisciplina,'(',c.NombreCategoria,')[',c.Genero,']') as Discat, l.NombreLugar, FechahoraEvento, EstadoEvento
					FROM evento e, lugar l, disciplina d, categoria c, competidor comp, equipo eq, conforma conf, participante pa, persona pe
					WHERE conf.IdPersona=$id
						AND comp.idevento=e.idevento
						AND comp.idequipo=eq.idequipo
						AND conf.idequipo=eq.idequipo
						AND conf.idpersona=pa.idpersona
						AND pa.idpersona=pe.idpersona
						AND l.IdLugar=e.IdLugar
						AND d.IdDisciplina = c.IdDisciplina
						AND e.IdCategoria = c.IdCategoria
						GROUP BY e.IdEvento";
           
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }
        }

        if(mysqli_num_rows($result)==0){
            echo "<p style='text-align: center; font-style: italic;'>No se han encontrado eventos para la fecha.</p>";
        }

        while ($row = $result->fetch_assoc()) {
			
			$nombre = $row['NombreEvento'];
			$categoria = $row['Discat'];
			$lugar = $row['NombreLugar'];
			$fechaHora = $row['FechahoraEvento'];
			$estado = $row['EstadoEvento'];

			$evento = new Evento(0, $nombre, $categoria, $fechaHora, $lugar, $estado, 0);
			$this->insertar($evento);
        }
	}
	
	public function impactar($idfase){
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

			foreach ($this->coleccion as $fila){
				
				echo "INSERT INTO evento VALUES(".$fila->GetId_Evento().",".$fila->GetLugar_Evento().",".$fila->GetCategoria_Evento().",".$idfase.",'".$fila->GetNombre_Evento()."',STR_TO_DATE('".$fila->GetFechaHora_Evento()."', '%Y-%m-%d %h:%i'),'','".$fila->GetEstado_Evento()."')";
		        echo "<br>";
		        $sql = "INSERT INTO evento VALUES(".$fila->GetId_Evento().",".$fila->GetLugar_Evento().",".$fila->GetCategoria_Evento().",".$idfase.",'".$fila->GetNombre_Evento()."',STR_TO_DATE('".$fila->GetFechaHora_Evento()."', '%Y-%m-%d %h:%i'),'','".$fila->GetEstado_Evento()."')";
		       
		        $connection->query($sql);
		        
			}
			$connection->close();
		}
	}

	public function eliminar(){
		$dbusername = "toDelete";
	    $dbpass = "toDelete";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	    mysqli_select_db($connection, DBNAME);

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    }else {

	            foreach ($this->coleccion as $fila){

	            	$sql = "DELETE FROM evento WHERE idevento = ".$fila->GetId_Evento()."";
	            	echo $sql;
	            	$result = $connection->query($sql);
	            	$connection->close();	
				}
	    }
	}
	

	
	public function actualizar($fase){
		$dbusername = "toUpdate";
	    $dbpass = "toUpdate";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	    mysqli_select_db($connection, DBNAME);
	    $connection->set_charset("utf8");

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    } else {

	            foreach ($this->coleccion as $fila){

	            	$sql = "UPDATE evento SET NombreEvento='".$fila->GetNombre_Evento()."', IdLugar=".$fila->GetLugar_Evento().", IdCategoria=".$fila->GetCategoria_Evento().", FechahoraEvento='".$fila->GetFechaHora_Evento()."', EstadoEvento='".$fila->GetEstado_Evento()."', IdCompetencia='".$fase."' WHERE IdEvento = ".$fila->GetId_Evento()."";
	            	echo $sql;
	            	$result = $connection->query($sql);
	            		
				}
	      	}
	    
	}

	public function actualizarequipos(){
		$dbusername = "toUpdate";
	    $dbpass = "toUpdate";

	    $connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);
	    mysqli_select_db($connection, DBNAME);
	    $connection->set_charset("utf8");

	    if ($connection->connect_error) {
	        die("La conexión a la base de datos ha fallado." . $connection->connect_error);
			$connection->close();
	    }else { 
	        	foreach ($this->coleccion as $fila){
	        		echo "DELETE FROM competidor WHERE idevento=".$fila->GetId_Evento()."";
	        		$sql2 = "DELETE FROM competidor WHERE idevento=".$fila->GetId_Evento()."";
					$result2 = $connection->query($sql2) or die(mysqli_error($connection));
					
					for($i=0; $i<$fila->GetEquipos()->largo(); $i++){
				
						$integrante = $fila->GetEquipos()->getValor($i + 1);

	        			echo "INSERT INTO competidor VALUES (0,".$integrante->GetId_Equipo().",".$fila->GetId_Evento().")";
						$sql3 = "INSERT INTO competidor VALUES (0,".$integrante->GetId_Equipo().",".$fila->GetId_Evento().")";
						$result3 = $connection->query($sql3) or die(mysqli_error($connection));
					}
				}
				
				$connection->close();
	        }
	    
	}	
}

