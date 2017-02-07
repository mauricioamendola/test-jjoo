<?php
	include 'scripts/dbcfg.php';
	function generaPaises(){
		/*conectar();
		desconectar();
		$consulta=mysql_query("SELECT idPais, NombrePais FROM Pais");*/

		$dbusername = "infoSelect";
		$dbpass = "infoselectpass";
		$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);

		$query = "SELECT idPais, NombrePais FROM Pais";
		$connection->set_charset("utf8");

		$result = mysqli_query($connection, $query);

		// Voy imprimiendo el primer select compuesto por los paises
		echo "<select name='paises' id='paises' onChange='cargaContenido(this.id)' class='form-control'>";
		echo "<option value='0'>Elige</option>";
		while($registro=$result->fetch_assoc())
		{
			echo "<option value='".$registro['idPais']."'>".$registro['NombrePais']."</option>";
		}
		echo "</select>";

	}

	// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
	$listadoSelects=array(
	"paises"=>"lista_paises",
	"deportista"=>"lista_deportista"
	);

	function validaSelect($selectPais){
		// Se valida que el select enviado via GET exista
		global $listadoSelects;
		if(isset($listadoSelects[$selectPais])) return true;
		else return false;
		echo "validaSelect";
	}

	function validaOpcion($opcionSeleccionada){
		// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
		if(is_numeric($opcionSeleccionada)) return true;
		else return false;
		echo "validaOpcion";
	}

	function poblarSelect($select, $opcion){
		if(isset($_REQUEST["deportista"]) and isset($_REQUEST["opcion"])){
			$selectPais=$_REQUEST["deportista"]; $opcionSeleccionada=$_REQUEST["opcion"];
			echo "hola1";


			if(validaSelect($selectPais) && validaOpcion($opcionSeleccionada)){
				$tabla=$listadoSelects[$selectPais];

				echo "hola2";
				/*conectar();
				$consulta=mysql_query("SELECT G.IdPersona, G.NombrePersona, G.ApellidoPersona
			                            FROM Persona G, Delegacion DL, Participante J, Pais P
			                            WHERE P.IdPais = '$opcionSeleccionada'
			                                AND P.idPais = J.idPais
			                                AND G.IdPersona = J.IdPersona
			                                AND J.IdDelegacion = DL.IdDelegacion") or die(mysql_error());
				desconectar();*/

				$dbusername = "infoSelect";
				$dbpass = "infoselectpass";
				$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);

				$consulta = "SELECT G.IdPersona, G.NombrePersona, G.ApellidoPersona
			                            FROM Persona G, Delegacion DL, Participante J, Pais P, Integra2 I
			                            WHERE P.IdPais = '$opcionSeleccionada'
			                                AND P.idPais = J.idPais
			                                AND G.IdPersona = J.IdPersona
			                                AND I.IdPersona = J.IdPersona
			                                AND I.IdDelegacion = DL.IdDelegacion";

				$connection->set_charset("utf8");

			    $resultado = $consulta->mysql_query();
			    echo "hola3";

				// Comienzo a imprimir el select
				//echo "<select name='".$selectPais."' id='".$selectPais."' onChange='cargaContenido(this.id)' size= '10' class='form-control'>";
				echo "<select name='atletas' id='atletas' onChange='cargaContenido(this.id)' size= '10' class='form-control'>";
				while($registro=$resultado->fetch_assoc()){
					echo "hola4";
					// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
					//$registro['G.NombrePersona']=htmlentities($registro['G.NombrePersona']);
					// Imprimo las opciones del select
					echo "<option value='".$registro['G.IdPersona']."'>".$registro['G.NombrePersona']." ".$registro['G.ApellidoPersona']."</option>";
				}
				echo "</select>";
			}
		}
	}

	//if(isset($_REQUEST['poblar']) and $_REQUEST['poblar']==1){
		//poblarSelect($_REQUEST['select'], $_REQUEST['opcion']);
		if(isset($_REQUEST["select"]) and isset($_REQUEST["opcion"])){
			$selectPais=$_REQUEST["select"]; $opcionSeleccionada=$_REQUEST["opcion"];


			if(validaSelect($selectPais) && validaOpcion($opcionSeleccionada)){
				$tabla=$listadoSelects[$selectPais];

			if(validaSelect($selectPais) && validaOpcion($opcionSeleccionada)){
				$tabla=$listadoSelects[$selectPais];
				/*conectar();
				$consulta=mysql_query("SELECT G.IdPersona, G.NombrePersona, G.ApellidoPersona
			                            FROM Persona G, Delegacion DL, Participante J, Pais P
			                            WHERE P.IdPais = '$opcionSeleccionada'
			                                AND P.idPais = J.idPais
			                                AND G.IdPersona = J.IdPersona
			                                AND J.IdDelegacion = DL.IdDelegacion") or die(mysql_error());
				desconectar();*/

				$dbusername = "infoSelect";
				$dbpass = "infoselectpass";
				$connection = new mysqli(DBSERV, $dbusername, $dbpass, DBNAME);

				$consulta01 = "SELECT G.IdPersona, G.NombrePersona, G.ApellidoPersona
			                            FROM Persona G, Delegacion DL, Participante J, Pais P, Integra2 I
			                            WHERE P.IdPais = '".$opcionSeleccionada."'
			                                AND P.idPais = J.idPais
			                                AND G.IdPersona = J.IdPersona
			                                AND I.IdPersona = J.IdPersona
			                                AND I.IdDelegacion = DL.IdDelegacion";

				$connection->set_charset("utf8");

			    $consulta= "SELECT G.IdPersona, G.NombrePersona, G.ApellidoPersona
							FROM Persona G, delegacion DL, participante J, equipo E, deportista D, Torneo T, conforma K, Pais P, Integra2
							WHERE DL.IdDelegacion ='".$opcionSeleccionada."'
								AND G.IdPersona = D.IdPersona
								AND D.IdPersona = J.Idpersona
								AND	G.IdPersona = J.IdPersona
								AND I.IdPersona = J.IdPersona
								AND I.IdDelegacion = DL.IdDelegacion	
								AND K.IdPersona = J.IdPersona
								and K.IdEquipo = E.IdEquipo
								AND	e.IdTorneo = T.idtorneo
								GROUP BY G.IdPersona";
			   	//no entiendo porque no funciona, sin los if me levanta la consulta con if no
				if ($_REQUEST['FiltroPor'] == '1') {
			   	    $resultado = mysqli_query($connection, $consulta);
			   } elseif ($_REQUEST['FiltroPor'] == '2') {
			   		$resultado = mysqli_query($connection, $consulta01);
			   }

				// Comienzo a imprimir el select
				//echo "<select name='".$selectPais."' id='".$selectPais."' onChange='cargaContenido(this.id)' size= '10' class='form-control'>";
				//echo "<select name='atletas' id='atletas' onChange='cargaContenido(this.id)' size= '10' class='form-control'>";

				while($registro1=$resultado->fetch_assoc()){
					// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
					//$registro['G.NombrePersona']=htmlentities($registro['G.NombrePersona']);
					// Imprimo las opciones del select
					echo "<option class='h' value='".$registro1['IdPersona']."'>".$registro1['NombrePersona']." ".$registro1['ApellidoPersona']." ".$_REQUEST['FiltroPor']."</option>";
				}

				}
				//echo "</select>";
			}
		}
	//}

?>
