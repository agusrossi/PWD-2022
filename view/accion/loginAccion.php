<?php include_once "../../config.php";
$data = data_submitted();

$logueado = $sesion->logear($data);
if ($sesion != false && $sesion->getObjUsuario() != null) {

  if ($sesion->activa() and $sesion->getObjUsuario()->getUsDeshabilitado() != null) {

    $rolesUsuario = $sesion->getColRol();
    // echo "sesion activa y usuario sin rol";
    if (empty($rolesUsuario)) {
      header("Location: ../indexIns.php?error=3");
      $sesion->cerrar();
    } else {
      // echo "sesion activa y usuario con rol";
      $_SESSION['rol'] = $rolesUsuario[0]->getIdRol();
      header("Location: ../comprar.php");
    }
  } elseif ($sesion->getObjUsuario()->getUsDeshabilitado()) {
    // echo "sesion activa y usuario deshabilitado";
    header("Location: ../indexIns.php?error=2");
    $sesion->cerrar();
  }
} else {
  // echo "la contraseña o usuario no coinciden";
  header("Location: ../indexIns.php?error=1");
}
