<?php include_once '../../config.php';
include_once '../../util/funciones.php';
$data = data_submitted();

if ($data['accion'] == 'nuevo') {
    nuevoProd($data);
}
if ($data['accion'] == 'modificar') {
    modificarProd($data);
}
if ($data['accion'] == 'eliminar') {
    eliminarProd($data);
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
}

function modificarProd($data) {
    $abmProd = new AbmProducto();


    $prod = $abmProd->abm($param);
    if ($prod) {
        $mensaje = ['icono' => 'success', 'mensaje' => 'Se agrego correctamente'];
    } else {
        $mensaje = ['icono' => 'error', 'mensaje' => 'No se pudo agregar'];
    }
}


function eliminarProd($data) {
    $abmProd = new AbmProducto();


    $prod = $abmProd->abm($param);
    if ($prod) {
        $mensaje = ['icono' => 'success', 'mensaje' => 'Se agrego correctamente'];
    } else {
        $mensaje = ['icono' => 'error', 'mensaje' => 'No se pudo agregar'];
    }
}




// agregar nuevo:
//     ["prodetalle"]=>
//     string(4) "null"
//     ["pronombre"]=>
//     string(4) "null"
//     ["procantstock"]=>
//     string(4) "null"
//     ["precio"]=>
//     string(4) "null"
//     ["accion"]=>
//     string(5) "nuevo"
//   }



// editar
// ["idproducto"]=>
// string(1) "1"
// ["prodetalle"]=>
// string(29) "imagenes/camiseta hombre.jfif"
// ["pronombre"]=>
// string(20) "Camiseta Hombre edit"
// ["procantstock"]=>
// string(1) "0"
// ["precio"]=>
// string(4) "3000"
// ["prodeshabilitado"]=>
// string(4) "null"
// ["accion"]=>
// string(9) "modificar"
// }


// eliminar
// ["idproducto"]=>
// string(1) "1"
// ["prodetalle"]=>
// string(29) "imagenes/camiseta hombre.jfif"
// ["pronombre"]=>
// string(20) "Camiseta Hombre edit"
// ["procantstock"]=>
// string(1) "0"
// ["precio"]=>
// string(4) "3000"
// ["prodeshabilitado"]=>
// string(4) "null"
// ["accion"]=>
// string(9) "eliminar"
// }