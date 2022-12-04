<?php
include_once "../config.php";
// $control = new NavbarControl();
$urlActual = $_SERVER['PHP_SELF'];
$urlActual = explode('/', $urlActual);
$urlActual = $urlActual[count($urlActual) - 1];

$rolActual = new AbmRol();
$menuRol = new AbmMenuRol();
$objMenus = new AbmMenu();
$abmCompra = new AbmCompra();

if ($sesion->activa()) {
  $roles = $sesion->getColRol();
  $rolActual = $rolActual->rolActual($sesion);
  $menuRol = $menuRol->menuRol($sesion);
  $menus = $objMenus->menus($sesion);

  $ultimaCompra = $abmCompra->getUltimaCompra($sesion->getObjUsuario()->getIdUsuario());
  $cantItem = 0;
  if ($ultimaCompra && empty($ultimaCompra->getColCompraEstados())) {
    foreach ($ultimaCompra->getColCompraItems() as $item) {
      $cantItem++;
    }
  }
}

?>

<!-- barra de navegacion -->
<nav class="navbar navbar-expand-lg navbar-light">

  <div class="container-fluid">

    <!-- Imagen logo, con link a la pagina de inicio-->
    <?php
    if ($sesion->activa()) {
    ?>
      <a class="navbar-brand mx-5" href="comprar.php"><img src="assets/imagenes/titulo.png" alt="" style="width: 75px;"></a>
    <?php
    } else {
    ?>
      <a class="navbar-brand mx-5" href="indexIns.php"><img src="assets/imagenes/titulo.png" alt="" style="width: 75px;"></a>
    <?php
    }
    ?>

    <!-- Boton nav responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">

      <!-- Menus de usuarios -->
      <!-- Verifico que la sesion este activa -->
      <?php if ($sesion->activa()) { ?>

        <!-- Menu Rol -->
        <!-- Si existe menu padre  -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <?php if (isset($menus)) {
            ?>

              <a class="btn btn-outline-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $menus[0]->getMeNombre(); ?>
              </a>

              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <?php unset($menuRol[0]); ?>

                <!-- escribo cada item(menu hijo) del menu padre -->
                <?php foreach ($menuRol as $menu) {
                  if (!$menu->getObjMenu()->getMeDeshabilitado()) {
                    echo "<li><a class='dropdown-item' href='" . $menu->getObjMenu()->getMeNombre() . ".php?idmenu=" . $menu->getObjMenu()->getidMenu() . "'>" . $menu->getObjMenu()->getMeNombre() . "</a></li>";
                  }
                } ?>
              </ul>
            <?php } ?>
          </li>
        </ul>


        <!-- Cambiar Roles -->
        <?php if (isset($roles) && count($roles) > 1) { ?>
          <div class="dropdown">
            <button class="btn btn-outline-dark btnCarro dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-eye-fill"></i>
            </button>
            <!-- se muestran los roles disponibles para ese usuario -->
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <?php foreach ($roles as $rol) { ?>
                <li>
                  <a class='dropdown-item' href='cambiarRol.php?idrol=<?= $rol->getIdRol() ?>&url=<?= $urlActual ?>'><?= $rol->getRoDescripcion() ?> </a>

                </li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>

        <!-- Info Carrito -->
        <a class="btn btn-outline-dark btnCarro ms-3" href="carrito.php" type="button">
          <i class="bi-cart-fill me-1"></i>
          Carrito
          <span class="badge bg-celeste text-white ms-1 rounded-pill incrementoCarrito">
            <?= $cantItem ?></span>
        </a>

      <?php } ?>

      <!-- Boton Login -->
      <div class="dropdown ms-3" style="margin-right: 9rem;">

        <?php if ($sesion->activa()) { ?>
          <button type="submit" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" name="cerrarSesion">
            <i class="bi bi-person-fill"></i>
            <?= $sesion->getObjUsuario()->getUsNombre(); ?>
          </button>

          <div class="dropdown-menu p-2">
            <li><a class="dropdown-item" href="#/">Mi Perfil</a></li>
            <li> <a class="btn btn-outline-dark" href="./accion/loginCerrar.php" role="button">Cerrar sesion</a></li>
          </div>

        <?php } else { ?>
          <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <i class="bi bi-person-fill"></i>
            Login
          </button>


          <form class="dropdown-menu p-4 needs-validation" novalidate style="width: 230px;" action="accion/loginAccion.php" method="POST">
            <div class="mb-3">
              <label for="exampleDropdownFormEmail2" class="form-label">Email</label>
              <input type="text" class="form-control" name="usnombre" id="usnombre" placeholder="Usuario" required />
              <div class="invalid-feedback">
                Este campo es obligatorio
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleDropdownFormPassword2" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="uspass" id="uspass" placeholder="Password" required />
              <div class="invalid-feedback">
                Este campo es obligatorio
              </div>
            </div>

            <button type="submit" class="btn btn-outline-dark">
              Iniciar Sesión
            </button>
            <a class="btn btn-outline-dark" role='button' href="registrarse.php">Registrarse</a>
            <!-- <a class="btn btn-outline-dark btnCarro ms-3" href="" type="button"></a> -->

          </form>

        <?php } ?>
      </div>

    </div>
  </div>
</nav>
<?php

?>
<script src="./assets/js/validation.js"></script>