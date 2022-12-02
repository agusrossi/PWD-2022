<?php include_once '../../config.php';
include_once '../../util/funciones.php';
$data = data_submitted();
$estado = new AbmCompraEstado();
$compra = new AbmCompra();
$compraActual = new AbmCompra();

// la compra va a ser la q este en estado iniciada sino creo una nueva
$compra = $compra->getUltimaCompra($sesion->getObjUsuario()->getIdUsuario());

/**
 * CORREGIR :tiene que tener estado = 1(iniciada) o generar un nuevo estado que sea precarga
 * si la ultima compra tiene estado 
 */

if (empty($compra) || !empty($compra->getColCompraEstados())) {
    $data['cofecha'] = date('Y-m-d H:i:s');
    $abmcompra = new AbmCompra();
    $datosCompra = $abmcompra->alta($data);
    $compraActual = $compraActual->buscar(['idcompra' => $datosCompra['idcompra']])[0];
} else {

    $compraActual = $compra;
}
//busco si la compra tiene items

$data['idcompra'] = $compraActual->getIdCompra();
$colItemCompra = $compraActual->getColCompraItems();

$colIdItems = [];
// recorro los items y guardo sus id
foreach ($colItemCompra as $item) {

    $colIdItems[] = $item->getObjProducto()->getIdProducto();
}
$objProd = new AbmProducto();
$objProd = $objProd->buscar($data['idproducto']);


//verifico si el item que viene por parametro ya se encuentra en la compra
if (in_array($data['idproducto'], $colIdItems)) {

    $aux = new AbmCompraItem;
    $param = ['idproducto' => $data['idproducto'], 'idcompra' => $data['idcompra']];
    $item = $aux->buscar($param);
    $cant = $item[0]->getCiCantidad() + $data['cicantidad'];
    if ($data['cicantidad'] <= $objProd[0]->getProCantStock()) {
        $item[0]->setCiCantidad($cant);
        $item[0]->modificar();
    }else{
        header("Location: ../comprar.php");
    }
} else {


    if ($data['cicantidad'] <= $objProd[0]->getProCantStock()) {
        $item = new AbmCompraItem();
        $aux = $item->alta($data);
    } else {
        header("Location: ../comprar.php?error=1");
    }
}
header("Location: ../carrito.php");
