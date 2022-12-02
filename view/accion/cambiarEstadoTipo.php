<?php
include_once "../../config.php";

$data = data_submitted();


$abmCompraEstado = new AbmCompraEstado();
$compraEstado = $abmCompraEstado->buscar(['idcompra' => $data['idcompra'], 'cefechafin' => null]);
if (!empty($compraEstado)) {
    $compraEstado[0]->setCeFechaFin(date('Y-m-d H:i:s'));
    $compraEstado[0]->modificar();

    $compraEstadoMod = new AbmCompraEstado();
    $param = [
        'accion' => 'nuevo',
        'idcompra' => $data['idcompra'],
        'idcompraestadotipo' => $data['idcompraestadotipo'],
        'cefechaini' => date('Y-m-d H:i:s'),
        'cefechafin' => null
    ];

    $compraEstadoMod = $abmCompraEstado->abm($param);

    if ($data['idcompraestadotipo'] == 4) {
        $abmCompraItem = new AbmCompraItem();
        $colCompraItem = $abmCompraItem->buscar(['idcompra' => $data['idcompra']]);

        foreach ($colCompraItem as $compraI) {
            $cant = $compraI->getCiCantidad();
            $prod = $compraI->getObjProducto();
            $stock = $prod->getProCantStock();
            $prod->setProCantStock(intval($stock + $cant));
            $prod->modificar();
        }
    }
} else {
    echo "error";
}
