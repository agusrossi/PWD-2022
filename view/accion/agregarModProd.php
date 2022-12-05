<?php include_once '../../config.php';
include_once '../../util/funciones.php';
$data = data_submitted();
if (!empty($data)) {
    if ($data['accion'] == 'nuevo') {

        $mensaje = nuevoProd($data);
    }
    if ($data['accion'] == 'modificar') {
        $mensaje =  modificarProd($data);
    }
    if ($data['accion'] == 'eliminar') {
        $mensaje = eliminarProd($data);
    }
    json_encode($mensaje);
}
function nuevoProd($data) {
    $abmProd = new AbmProducto();
  
    $param = ['accion' => 'nuevo', 'pronombre' => $data['pronombre'], 'prodetalle' => $data['prodetalle'], 'procantstock' => $data['procantstock'], 'precio' => $data['precio'], 'prodeshabilitado' => null];
    $prod = $abmProd->abm($param);
 
    if ($prod) {
        $mensaje = ['icono' => 'success', 'mensaje' => 'Se agrego correctamente'];
    } else {
        $mensaje = ['icono' => 'error', 'mensaje' => 'No se pudo agregar'];
    }
    return $mensaje;
}

function modificarProd($data) {
    $abmProd = new AbmProducto();
    if ($data['prodeshabilitado'] == '0000-00-00 00:00') {
        $data['prodeshabilitado'] = null;
    }
    $param = ['idproducto' => $data['idproducto'], 'prodetalle' => $data['prodetalle'], 'pronombre' => $data['pronombre'], 'procantstock' => $data['procantstock'], 'precio' => $data['precio'], 'prodeshabilitado' => $data['prodeshabilitado'], 'accion' => 'editar'];

    $prod = $abmProd->abm($param);

    if ($prod) {
        $mensaje = ['icono' => 'success', 'mensaje' => 'Se modico correctamente'];
    } else {
        $mensaje = ['icono' => 'error', 'mensaje' => 'No se pudo modificar'];
    }
    return $mensaje;
}


function eliminarProd($data) {
    $abmProd = new AbmProducto();
    $param = ['idProducto' => $data['idproducto'], 'prodetalle' => $data['prodetalle'], 'pronombre' => $data['pronombre'], 'procantstock' => $data['procantstock'], 'precio' => $data['precio'], 'prodeshabilitado' => $data['prodeshabilitado'], 'accion' => 'borrar'];

    $prod = $abmProd->abm($param);
    if ($prod) {
        $mensaje = ['icono' => 'success', 'mensaje' => 'Se elimino correctamente'];
    } else {
        $mensaje = ['icono' => 'error', 'mensaje' => 'No se pudo eliminar'];
    }
    return $mensaje;
}
