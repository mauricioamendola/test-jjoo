<?php
session_start();
include_once 'includes/lugares.php';

function fillMarkers(){
    //Creo una colección con los lugares ingresados en la BD.
    $lista = new lugares();
    $lista->poblarLugares();

    //Array auxiliar para poder pasarle a JavaScript los lugares
    $listaLugares = [];
    for($i=1; $i<=$lista->largo(); $i++){
        $lugar = $lista->getValor($i);
        $toReturn[] = array("Id" => $lugar->GetId_Lugar(), "Nombre" => $lugar->GetNombre_Lugar(), "TipoServicio" => $lugar->GetTipo_Servicio(), "Latitud" => $lugar->GetLatitud_Lugar(),"Longitud" =>$lugar->GetLongitud_Lugar(),"Direccion" =>$lugar->GetDireccion_Lugar(),"Web" =>$lugar->GetWeb_Lugar());
    }
    echo json_encode($toReturn); //Encodeo en JSON el array para que JavaScript lo pueda leer
}


    function fillMarkersFiltro($filtro){
    //Creo una colección con los lugares ingresados en la BD.
    $lista = new lugares();
    $lista->poblarLugaresfiltro($filtro);

    //Array auxiliar para poder pasarle a JavaScript los lugares
    $listaLugares = [];
    for($i=1; $i<=$lista->largo(); $i++){
        $lugar = $lista->getValor($i);
        $toReturn[] = array("Id" => $lugar->GetId_Lugar(), "Nombre" => $lugar->GetNombre_Lugar(), "TipoServicio" => $lugar->GetTipo_Servicio(), "Latitud" => $lugar->GetLatitud_Lugar(),"Longitud" =>$lugar->GetLongitud_Lugar(),"Direccion" =>$lugar->GetDireccion_Lugar(),"Web" =>$lugar->GetWeb_Lugar());
    }
    echo json_encode($toReturn); //Encodeo en JSON el array para que JavaScript lo pueda leer

}

    //Según el valor de la variable q, es qué función llamo.
    if(isset($_REQUEST['q'])){
        switch($_REQUEST['q']){
            case 'fillMarkers':
                fillMarkers();
                break;
            case 'fillMarkersFiltro':
                fillMarkersFiltro($_REQUEST['tipo']);
                break;
    }
}

?>
