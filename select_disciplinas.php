<?php
	include 'scripts/conexion.php';
	function generaDisciplina(){
		
		$sql="SELECT idDisciplina, NombreDisciplina FROM Disciplina";
		// Voy imprimiendo el primer select compuesto por los Disciplina
		echo "<select name='Disciplina' id='Disciplina' onChange='cargaContenido(this.id)' class='form-control'>";
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
	"Disciplina"=>"lista_Disciplina",
	"Categoria"=>"lista_Delegacion"
	);

	function validaSelect($selectDisciplina){
		// Se valida que el select enviado via GET exista
		global $listadoSelects;
		if(isset($listadoSelects[$selectDisciplina])) return true;
		else return false;
	}

	function validaOpcion($opcionSeleccionada){
		// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
		if(is_numeric($opcionSeleccionada)) return true;
		else return false;
	}

	if (isset($_REQUEST["select"])) {
    $selectDisciplina = trim(strip_tags($_REQUEST["select"]));
			} else {
    $selectDisciplina = "";
		}

	if (isset($_REQUEST["opcion"])) {
    $opcionSeleccionada = trim(strip_tags($_REQUEST["opcion"]));
			} else {
    $opcionSeleccionada = "";
		}


	if(validaSelect($selectDisciplina) && validaOpcion($opcionSeleccionada)){
		$tabla=$listadoSelects[$selectDisciplina];
		$sql="SELECT C.IdCategoria, C.NombreCategoria, C.Genero
	          FROM Categoria C, Disciplina D
	          WHERE C.idDisciplina = '$opcionSeleccionada'
	          AND D.idDisciplina = '$opcionSeleccionada'";

		if ($consulta=DBi::$conn->query($sql)){

		// Comienzo a imprimir el select
			echo "<select name='".$selectDisciplina."' id='".$selectDisciplina."' onChange='cargaContenido(this.id)' size= '10' class='form-control'>";
			
			while($registro=mysqli_fetch_row($consulta)){
			// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
				$registro[1]=htmlentities($registro[1]);
			// Imprimo las opciones del select
				echo "<option value='".$registro[0]."'>".$registro[1]." ".$registro[2]."</option>";
			}	

			echo "</select>";
		}
	}
?>