<?php
include_once "../scripts/includes/eventos.php";

function getDatos(){
    $data = new eventos();
    $data->poblarPorId($_REQUEST['id']);
    $datos = array();
    for($i=1; $i<=$data->largo(); $i++){
        $evento = $data->getValor($i);
        $datos = array(
                    "id" => $evento->GetId_Evento(),
                    "nombre" => $evento->GetNombre_Evento(),
                    "disciplina" => $evento->GetDisciplina_Evento(),
                    "categoria" => $evento->GetCategoria_Evento(),
                    "genero" => $evento->GetGenero_Evento(),
                    "fechahora" => $evento->GetFechahora_Evento(),
                    "lugar" => $evento->GetLugar_Evento(),
                    "estado" => $evento->GetEstado_Evento()
                 );
    }

    echo json_encode($datos);
}

function getMes($mes){
    switch($mes){
        case 1:
            return "enero";
            break;
        case 2:
            return "febrero";
            break;
        case 3:
            return "marzo";
            break;
        case 4:
            return "abril";
            break;
        case 5:
            return "mayo";
            break;
        case 6:
            return "junio";
            break;
        case 7:
            return "julio";
            break;
        case 8:
            return "agosto";
            break;
        case 9:
            return "septiembre";
            break;
        case 10:
            return "octubre";
            break;
        case 11:
            return "noviembre";
            break;
        case 12:
            return "diciembre";
            break;
    }
}

function llenarTabla($idtorneo){
    $fechador = new eventos();
    $fechas = $fechador->poblarFechas($idtorneo);
    foreach($fechas as $fecha){
        $mes = substr($fecha, 5, 2);
        $dia = substr($fecha, 8, 2);
        $año = substr($fecha, 0, 4);

        $llenar = new eventos();
        $llenar->poblarPorFecha($dia, $mes, $año, $idtorneo);

        echo "<h3>" . $dia . " de " . getMes($mes) . "</h3>";
        echo "<div class='table-responsive'>";
            echo "<table class='table'>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>Nombre</th>";
                        echo "<th>Disciplina</th>";
                        echo "<th>Categoría</th>";
                        echo "<th>Género</th>";
                        echo "<th>Lugar</th>";
                        echo "<th>Hora</th>";
                        echo "<th>Estado</th>";
                    echo "</tr>";
                echo "</thead";
                echo "<tbody>";
                for ($i=1; $i<=$llenar->largo(); $i++){
                    echo "<tr class='selectable-row' onclick='selectMe(".$llenar->getValor($i)->GetId_Evento().")'>";
                    echo "<td>" . $llenar->getValor($i)->GetNombre_Evento() . "</td>";
                    echo "<td>" . $llenar->getValor($i)->GetDisciplina_Evento() . "</td>";
                    echo "<td>" . $llenar->getValor($i)->GetCategoria_Evento() . "</td>";
                    echo "<td>" . $llenar->getValor($i)->GetGenero_Evento() . "</td>";
                    echo "<td>" . $llenar->getValor($i)->GetLugar_Evento() . "</td>";
                    $hora = substr($llenar->getValor($i)->GetFechahora_Evento(), 11,5);
                    echo "<td>" . $hora . "</td>";
                    echo "<td>" . $llenar->getValor($i)->GetEstado_Evento() . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
            echo "</table>";
        echo "</div>";
    }
}

function updateEvento($id, $datos){
    echo $datos;
}

function addEvento($datos){
    $evento = json_decode($datos);
    $nombre = $evento->{'nombre'};
    $disciplina = $evento->{'disciplina'};
    $categoria = $evento->{'categoria'};
    $genero = $evento->{'genero'};
    $fechahora = $evento->{'fechahora'};
    $lugar = $evento->{'lugar'};
    $estado = $evento->{'estado'};

    $newevento = new Evento(0, $nombre, $disciplina, $categoria, $genero, $fechahora, $lugar, $estado);

    $newevento->insertar();
}

//==============================================================================

if(isset($_REQUEST['q'])){
    switch($_REQUEST['q']){
        case 'cargar':
            getDatos();
            break;
        case 'tabla':
            llenarTabla($_REQUEST['idtorneo']);
            break;
        case 'update':
            updateEvento($_REQUEST['datos']);
            break;
        case 'add':
            addEvento($_REQUEST['datos']);
            break;
    }
}
?>
