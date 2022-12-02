<?php
include_once "../../config.php";
$data = data_submitted();
$objCompraEs = new AbmCompraEstado();
$list = $objCompraEs->buscar($data);
$arreglo_salida = [];

foreach ($list as $elem) {

    $nuevoElem['idcompra'] = $elem->getObjCompra()->getIdCompra();
    $nuevoElem["idcompraestado"] = $elem->getObjCompraEstTipo()->getCetDescripcion();
    $nuevoElem["cefechaini"] = $elem->getCeFechaIni();
    $nuevoElem["cefechafin"] = $elem->getCeFechaFin();



    /* if($elem->getObjMenu()!=null){
        $nuevoElem["idproducto"]=$elem->getObjMenu()->getMeNombre();
    } */

    array_push($arreglo_salida, $nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida);
