<?php
	//Se crea una clase encargada de establecer la conexion como objeto.
	class DBi { 
    	public static $conn;
	}

	DBi::$conn = new mysqli("localhost", "root", "","olympicapp");//se crea el objeto de la conexion.
	DBi::$conn->set_charset('utf8');//Se establece el charset a utilizar por PHP al conectarse y sacar datos con la Base de datos. 
		if (DBi::$conn->connect_error) {
            die("La conexión a la base de datos ha fallado." . $connection->connect_error);
        }    
?>