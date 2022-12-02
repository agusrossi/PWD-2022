<?php
include_once "../../config.php";
$data = data_submitted();
$objProducto = new Producto();
$list = $objProducto->listar($data);
$arreglo_salida = [];

foreach ($list as $elem) {

    $nuevoElem['idproducto'] = $elem->getIdproducto();
    $nuevoElem["pronombre"] = $elem->getPronombre();
    $nuevoElem["prodetalle"] = '<img class="rounded-circle" style="height: 100px;" src="../assets/' . $elem->getProDetalle() . '"/>';
    $nuevoElem["procantstock"] = $elem->getProcantstock();

    $nuevoElem["precio"] = $elem->getPrecio();

    /* if($elem->getObjMenu()!=null){
        $nuevoElem["idproducto"]=$elem->getObjMenu()->getMeNombre();
    } */

    array_push($arreglo_salida, $nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida);
