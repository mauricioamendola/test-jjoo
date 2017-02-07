<?php
	include 'scripts/conexion.php';
	function generaPaises(){
		
		$sql="SELECT idPais, NombrePais FROM Pais";
		

		// Voy imprimiendo el primer select compuesto por los Pais
		echo "<select name='Pais' id='Pais' onChange='cargaContenido(this.id)' class='form-control'>";
		echo "<option value='0'>Elige</option>";

		if ($consulta=DBi::$conn->query($sql))
  		{
			while($registro=mysqli_fetch_row($consulta))
			{
			echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
			}

			mysqli_free_result($consulta); //libera los resultados en la variable.
		}

		DBi::$conn->close(); //cierra coneccion con la Base de datos. 
		
		echo "</select>";
	}

	// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
	$listadoSelects=array(
	"Pais"=>"lista_Pais",
	"Delegacion"=>"lista_Delegacion"
	);

	function validaSelect($selectPais){
		// Se valida que el select enviado via GET exista
		global $listadoSelects;
		if(isset($listadoSelects[$selectPais])) return true;
		else return false;
	}

	function validaOpcion($opcionSeleccionada){
		// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
		if(is_numeric($opcionSeleccionada)) return true;
		else return false;
	}

	if (isset($_REQUEST["select"])) {
    $selectpais = trim(strip_tags($_REQUEST["select"]));
			} else {
    $selectpais = "";
		}

	if (isset($_REQUEST["opcion"])) {
    $opcionSeleccionada = trim(strip_tags($_REQUEST["opcion"]));
			} else {
    $opcionSeleccionada = "";
		}

	if(validaSelect($selectpais) && validaOpcion($opcionSeleccionada)){
		
		$tabla=$listadoSelects[$selectpais];
		$sql="SELECT D.IdDelegacion, D.NombreDelegacion
	          FROM Delegacion D, Pais P, Integra I
	          WHERE I.idPais = '$opcionSeleccionada'
	          AND D.IdDelegacion = I.IdDelegacion
	          AND P.idPais = I.idPais
			  GROUP BY d.IdDelegacion";

		if ($consulta=DBi::$conn->query($sql)){
		
		
			// Comienzo a imprimir el select
			echo "<select name='".$selectpais."' id='".$selectpais."' onChange='cargaContenido(this.id)' size= '10' class='form-control'>";
			while($registro=mysqli_fetch_row($consulta)){
			// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
			$registro[1]=htmlentities($registro[1]);
			// Imprimo las opciones del select
			echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
			
			}			
		echo "</select>";
		}


	}
?>