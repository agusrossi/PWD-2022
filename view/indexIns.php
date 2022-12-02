<?php $title = 'index';

include_once './includes/head.php'; ?>
<?php include_once "./includes/navbar.php"; ?>

<?php
$controlProducto = new AbmProducto();
$arrProductos = $controlProducto->buscar("");

$rolActual = $sesion->getRolActual();

?>


<header class="py-5 mb-5 bg-celeste">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Tienda mi país</h1>
            <p class="lead fw-normal text-white-50 mb-0">
                Messi el mejor!!
            </p>
        </div>
    </div>
</header>
<div id="seccion-productos" class="container productos d-flex flex-wrap">

    <div class="container d-flex flex-wrap justify-content-center">

        <div class="row">

            <?php

            foreach ($arrProductos as $producto) {

                if (($rolActual == 2) || ($producto->getProDeshabilitado() == null && $rolActual != 2)) {
                    // Si el rol es deposito muestro todos los productos, si es otro rol y no esta deshabilitado tambien muestra
                    if (($producto->getProCantStock() >= 0)) { ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5">
                            <div class="card h-100">
                                <!-- imagen producto-->
                                <img class="card-img-top" style="height: 206px;" src="assets/<?= $producto->getProDetalle() ?>" alt="..." />
                                <!-- Detalle Producto-->
                                <div class="card-body p-4">

                                    <div class="text-center">
                                        <!-- Nombre producto-->
                                        <h5 class="fw-bolder"><?= $producto->getProNombre()  ?></h5>
                                        <!-- Precio producto-->
                                        <?= "$" . $producto->getprecio() ?>
                                    </div>
                                    <div class="text-center p-2">
                                        <p style="color: grey;">Stock disponible: <?= $producto->getProCantStock()  ?> </p>
                                    </div>
                                </div>
                                <!-- accion producto-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto btnAnadir disabled" href="#/">Agregar al carrito</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>


    </div>
</div>

<script>
    <?php
    $data = data_submitted();
    if (array_key_exists("error", $data) && $data["error"] == 1) { ?>
        alert("Usuario y/o contraseña incorrectos.");
    <?php } ?>
    <?php if (array_key_exists("error", $data) && $data["error"] == 3) { ?>
        alert("El usuario se encuentra dado de baja.");
    <?php } ?>
    <?php if (array_key_exists("error", $data) && $data["error"] == 2) { ?>
        alert("Usuario no tiene rol asignado");
    <?php } ?>
    <?php if (array_key_exists("error", $data) && $data["error"] == 4) { ?>
        alert("No tiene permiso para esta pagina");
    <?php } ?>
</script>

<?php include_once 'includes/footer.php' ?>