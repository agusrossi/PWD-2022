<?php include_once '../../config.php';
include_once '../../util/funciones.php';
$data = data_submitted();
$user = new AbmUsuario();
// verifico que ese usuario no este registrado ya

$encontrado = $user->buscar(['usnombre' => $data['usnombre'], 'usmail' => $data['usmail']]);

if (empty($encontrado)) {
    $param = ['accion' => 'nuevo', 'usnombre' => $data['usnombre'], 'uspass' => md5($data['uspass']), 'usmail' => $data['usmail'], 'usdeshabilitado' => null];
    // si no esta lo registro
    $res = $user->abm($param);
    if ($res) {
        $usuario = $user->buscar(['usnombre' => $data['usnombre'], 'usmail' => $data['usmail']]);
        $param = ['accion' => 'nuevo_rol', 'idusuario' => $usuario[0]->getIdusuario(), 'idrol' => 3];

        $r = $user->abm($param);

        $mensaje = ['icono' => 'success', 'mensaje' => 'Registrado con exito'];
    }
} else {
    $mensaje = ['icono' => 'error', 'mensaje' => 'Usuario ya registrado'];
}
echo json_encode($mensaje);
