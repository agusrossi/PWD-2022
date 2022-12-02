<?php include_once '../../config.php';
include_once '../../util/funciones.php';

$data = data_submitted();


if ($data['accion'] === 'comprar') {
    echo "comprar";
    comprar($data);
}
if ($data['accion'] === 'cancelar') {
    cancelar($data);
    echo "cancelar";
}
if ($data['accion'] === 'borrarItem') {
    borrarItem($data);
    echo "borrar item";
}


function comprar($data) {
    $estado = new AbmCompraEstado();
    $param = ['accion' => 'nuevo', 'idcompra' => $data['idcompra'], 'idcompraestadotipo' => 1, 'cefechaini' => date('Y-m-d H:i:s'), 'cefechafin' => null];
    $res = $estado->abm($param);
    $abmComItem = new AbmCompraItem();
    $colComItem = $abmComItem->buscar(['idcompra' => $data['idcompra']]);

    foreach ($colComItem as $colItem) {
        $objProd = $colItem->getObjProducto();
        $cant = $objProd->getProCantStock();
        $cantidadVend = $colItem->getCiCantidad();

        if ($cant >= $cantidadVend) {
            $objProd->setProCantStock(intval($cant - $cantidadVend));
            $objProd->modificar();
        }
    }
}


function cancelar($data) {
    $abmcompra = new AbmCompra();
    $compra = $abmcompra->buscar(['idcompra' => $data['idcompra']]);
    if (!empty($compra)) {
        if (empty($compra[0]->getColCompraItems())) {

            echo "no hay items";

            $data['accion'] = 'borrar';
            $abmcompra->abm($data);
        } else {
            $abmitem = new AbmCompraItem();

            foreach ($compra[0]->getColCompraItems() as $item) {
                $param = ['accion' => 'borrar', 'idcompraitem' => $item->getIdCompraItem()];
                $abmitem->abm($param);
            }
            $data['accion'] = 'borrar';
            $abmcompra->abm($data);
        }
    }
}

function borrarItem($data) {
    $abmitem = new AbmCompraItem();
    $param = ['accion' => 'borrar', 'idcompraitem' => $data['idcompraitem']];
    $abmitem->abm($param);
}
header("Location: ../comprar.php");
