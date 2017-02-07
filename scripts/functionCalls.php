<?php
    include_once "includes/deportistas.php";
    function getDeportistasByPais($idPais){
        $lista = new deportistas();
        $lista->poblarPorPais($idPais);
        for($i=0; $i < $lista->largo(); $i++){
            $atleta = $lista->getValor($i + 1);
            echo "<option class='h' value='" . $atleta->GetId_Persona() . "'>" . $atleta->GetPrimer_Nombre() . " " . $atleta->GetPrimer_Apellido() . "</option>";
        }
    }

    if (isset($_REQUEST["q"])){
        switch($_REQUEST["q"]){
            case "getDeportistasByPais":
            getDeportistasByPais($_REQUEST["id"]);
            break;
        }
    }
?>
