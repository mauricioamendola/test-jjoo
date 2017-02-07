<?php
include_once 'categoria.php';

class categorias{
	private $coleccion;

	public function __construct(){
		$this->coleccion=array();
	}

	public function insertar($categoria){
		$this->coleccion[]=$categoria;
	}

	public function getValor($posicion){
		return $this->coleccion[$posicion - 1];
	}

	public function borrar($numero){
		$numero=$numero-1;
		$this->coleccion[$numero]=NULL;
	}

	public function largo(){
		return count($this-> coleccion);
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

	public function poblar($id){
		$dbusername = "infoSelect";
        $dbpass = "infoselectpass";

        $connection = new mysqli(DBSERV, $dbusername, $dbpass);

        if ($connection->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        } else {
            mysqli_select_db($connection, DBNAME);
            $sql = "SELECT IdCategoria, NombreCategoria, DescripcionCategoria, Genero FROM categoria WHERE IdDisciplina='$id' ORDER BY NombreCategoria";
            $query = $connection->query($sql);
            if (!$query) {
                printf("Error: %s\n", mysqli_error($connection));
                exit();
            }

			while ($row = $query->fetch_assoc()) {
				$categoria = new Categoria($row['IdCategoria'], $row['NombreCategoria'], $row['Genero'], $row['DescripcionCategoria'], $id);
				$this->insertar($categoria);
			}
            $connection->close();
        }

	}






}
