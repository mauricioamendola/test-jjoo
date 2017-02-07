<?php
include_once('dbcfg.php');


function getAuditTable(){

    $dbusername = "infoSelect";
    $dbpass = "infoselectpass";
    $connection = new mysqli(DBSERV, $dbusername, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $sql = "SELECT IdAuditoria, NombreUsuario, Accion, Tabla, Date_format(FechaHoraAuditoria,'%d/%m/%y') as fecha, Date_format(FechaHoraAuditoria,'%H:%i:%s') as hora FROM auditoria ORDER BY fecha, hora";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
    }

        while ($row = $result->fetch_assoc()){
            
            echo "<tr>";
            echo "<td>".$row['IdAuditoria']."</td>";
            $UserName = utf8_encode($row['NombreUsuario']);
            $Accion = utf8_encode($row['Accion']);
            $Tabla = utf8_encode($row['Tabla']);
            echo "<td>".$UserName."</td>";
            echo "<td>".$Accion."</td>";
            echo "<td>".$Tabla."</td>";
            echo "<td>".$row['fecha']."</td>";
            echo "<td>".$row['hora']."</td>";
    
            $cat = "showaudit.php?aid=".$row['IdAuditoria']."";
            echo "<td><button type='button' class='btn btn-success btn-xs' onclick='location.href=\"".$cat."\"'><span class='glyphicon glyphicon-ok'></span>&nbsp&nbsp&nbspVer Detalle</button></td>";
            echo "</tr>";
        }
        $connection->close();
    }

function ShowAudit($id){

    $dbusername = "infoSelect";
    $dbpass = "infoselectpass";
    $connection = new mysqli(DBSERV, $dbusername, $dbpass);
    mysqli_select_db($connection, DBNAME);
    $sql = "SELECT IdAuditoria, NombreUsuario, Accion, Tabla, ValorAnterior, ValorNuevo, Date_format(FechaHoraAuditoria,'%d/%m/%y') as fecha, Date_format(FechaHoraAuditoria,'%H:%i:%s') as hora FROM auditoria 
            WHERE IdAuditoria = $id";


    $result = mysqli_query($connection, $sql);

    if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
    }

    while ($row = $result->fetch_assoc()){
        echo "<div class='col-md-4'>";
        echo "<div class='form-group'>
                <label for='UserName' class='form-label'>Nombre de Usuario:</label>
                <input type='text' name='UserName' id='UserName' class='form-control' value='".$row['NombreUsuario']."' disabled>
                </div>";
        echo "<div class='form-group'>
                <label for='Action' class='form-label'>Accion Realizada:</label>
                <input type='text' name='Action' id='Action' class='form-control' value='".$row['Accion']."' disabled>
                </div>";
        echo "<div class='form-group'>
                <label for='Table' class='form-label'>Tabla afectada:</label>
                <input type='text' name='Tabla' id='Tabla' class='form-control' value='".$row['Tabla']."' disabled>
                </div>";
        echo "</div>";
        echo "<div class='col-md-12'>";
        echo "<div class='form-group'>
                <label for='OldValue' class='form-label'>Valor anterior de los atributos:</label>
                <input type='text' name='OldValue' id='OldValue' class='form-control' value='".$row['ValorAnterior']."' disabled>
                </div>";
        echo "<div class='form-group'>
                <label for='NewValue' class='form-label'>Valor nuevo de los atributos:</label>
                <input type='text' name='NewValue' id='NewValue' class='form-control' value='".$row['ValorNuevo']."' disabled>
                </div>";
        echo "</div>";
        echo "<div class='col-md-4'>";
        echo "<div class='form-group'>
                <label for='Fecha' class='form-label'>Fecha:</label>
                <input type='text' name='Fecha' id='Fecha' class='form-control' value='".$row['fecha']."' disabled>
                </div>";
        echo "</div>";
        echo "<div class='col-md-4'>";
        echo "<div class='form-group'>
                <label for='Hora' class='form-label'>Hora:</label>
                <input type='text' name='Hora' id='Hora' class='form-control' value='".$row['hora']."' disabled>
                </div>";
        echo "</div>";
    $connection->close();   
    }



}



	if (isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case 'search':
                fillTableSearch($_REQUEST['s']);
                break;
        }
    }   


?>