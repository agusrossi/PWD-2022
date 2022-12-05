<?php $title = 'Modificar productos';
include_once('../config.php');
include_once './includes/head.php';
include_once "./includes/navbar.php";
?>
<?php
$data = data_submitted();
$tieneAcceso = $sesion->controlAcceso($data);
if ($tieneAcceso) { ?>
    <?php
    $objProducto = new AbmProducto();
    $colProd = $objProducto->buscar(null);
    ?>
    <div class="container pt-5">
        <!-- model nuevo producto -->
        <div class="container pt-3 pb-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-info me-md-1" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                Nuevo Producto
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalAgregarLabel">Nuevo Producto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form-modificar" class="needs-validation p-3 w-50 mx-auto mt-20vh" action="#" method="post" novalidate>

                                <!-- imagen -->
                                <div class="form-group mb-3">
                                    <label for="imagen">Imagen</label>
                                    <input type="file" name="imagen" class="form-control" id="imagenN" alt="" height="100" required>
                                </div>

                                <!-- Nombre -->
                                <div class="form-group mb-3">
                                    <label for="nombre">Nombre</label>
                                    <input type="nombre" name="nombre" class="form-control" id="nombreN" required>
                                </div>

                                <!-- Cantidad de stock -->
                                <div class="form-group mb-3">
                                    <label for="stock">Cantidad Stock</label>
                                    <input type="stock" name="stock" class="form-control" id="stockN" required>
                                </div>

                                <!-- Precio -->
                                <div class="form-group mb-3">
                                    <label for="precio">Precio</label>
                                    <input type="number" name="precio" class="form-control" id="precioN" required>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="nuevoProd()">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="modificarProducto">

            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Cantidad de Stock</th>
                    <th>Precio</th>
                    <th>Deshabilitado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($colProd)) {
                    foreach ($colProd as $key => $producto) {
                        // $compraEst = $compraEst[0];
                ?>
                        <tr style="border-bottom:2px solid white;">
                            <td><img src="assets/<?= $producto->getProDetalle() ?>" alt="" height="100"></td>
                            <td><?= $producto->getIdProducto() ?></td>
                            <td><?= $producto->getProNombre() ?></td>
                            <td><?= $producto->getProCantStock() ?></td>
                            <td><?= $producto->getPrecio() ?></td>
                            <td><?= $producto->getProDeshabilitado() ?></td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-info me-md-1" data-bs-toggle="modal" data-bs-target="#editar<?= $key ?>">
                                    Editar
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="editar<?= $key ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editar<?= $key ?>Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editar<?= $key ?>Label">Editar Producto</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-modificar" class="needs-validation p-3 w-50 mx-auto mt-20vh" action="#" method="post" novalidate>


                                                    <!-- imagen -->
                                                    <div class="form-group mb-3">
                                                        <label for="imagen">Imagen</label>
                                                        <input type="file" name="imagen" class="form-control" id="imagen<?= $key ?>" value="<?= $producto->getProDetalle() ?>" alt="" height="100" required>
                                                    </div>


                                                    <!-- Producto -->
                                                    <div class="form-group mb-3">
                                                        <label for="producto">Producto</label>
                                                        <input type="producto" name="producto" class="form-control" id="producto<?= $key ?>" value='<?= $producto->getIdProducto() ?>' disabled>
                                                    </div>

                                                    <!-- Nombre -->
                                                    <div class="form-group mb-3">
                                                        <label for="nombre">Nombre</label>
                                                        <input type="nombre" name="nombre" class="form-control" id="nombre<?= $key ?>" value='<?= $producto->getProNombre() ?>' required>
                                                    </div>

                                                    <!-- Cantidad de stock -->
                                                    <div class="form-group mb-3">
                                                        <label for="stock">Cantidad Stock</label>
                                                        <input type="stock" name="stock" class="form-control" id="stock<?= $key ?>" value='<?= $producto->getProCantStock() ?>' required>
                                                    </div>

                                                    <!-- Precio -->
                                                    <div class="form-group mb-3">
                                                        <label for="precio">Precio</label>
                                                        <input type="number" name="precio" class="form-control" id="precio<?= $key ?>" value='<?= $producto->getPrecio() ?>' required>
                                                    </div>
                                                    <!-- Deshabilitado -->
                                                    <div class="form-group mb-3">
                                                        <label for="deshabilitado">Deshabilitado</label>
                                                        <input type="date" name="deshabilitado" class="form-control" id="deshabilitado<?= $key ?>" value='<?= $producto->getProDeshabilitado()  ?>' required>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                                                <!-- <a href="accion/agregarModProd.php?accion=modificar" type="button" class="btn btn-primary">Enviar</a> -->
                                                <button type="button" class="btn btn-primary" onclick="cambiarEstado('<?= $key ?>','modificar')">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="cambiarEstado('<?= $key ?>', 'eliminar')" class="btn btn-outline-danger" type="button">Eliminar</button>
                            </td>
                        </tr>
                    <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No se encontraron compras registrados</td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>

<?php } else { ?>
    <div class="container d-flex justify-content-center align-items-start text-center mt-5">
        <div class="alert alert-danger mt-20vh" role="alert">
            <h4 class="alert-heading">Esta pagina es solo para deposito</h4>
        </div>
    </div>

<?php } ?>

<script>
    $(document).ready(function() {
        $('#modificarProducto').DataTable();
    });

    function nuevoProd() {
        const prodetalle = document.getElementById('imagenN');
        const pronombre = document.getElementById('nombreN');
        const procantstock = document.getElementById('stockN');
        const proprecio = document.getElementById('precioN');

        const formData = {
            'prodetalle': prodetalle.value,
            'pronombre': pronombre.value,
            'procantstock': procantstock.value,
            'precio': proprecio.value,
            'accion': 'nuevo'
        }
        $.ajax({
            type: "post",
            url: "accion/agregarModProd.php",
            data: formData,
            dataType: 'json',
            success: function(response) {
                const datos = (response)
                console.log(datos);
                if (datos != '') {
                    Swal.fire({
                        icon: datos.icono,
                        title: datos.mensaje
                    })
                }
            }

        });
    }

    function cambiarEstado(idmodal, accion) {

        const idproducto = document.getElementById('producto' + idmodal);
        const prodetalle = document.getElementById('imagen' + idmodal);
        const pronombre = document.getElementById('nombre' + idmodal);
        const procantstock = document.getElementById('stock' + idmodal);
        const proprecio = document.getElementById('precio' + idmodal);
        const prodeshabilitado = document.getElementById('deshabilitado' + idmodal);


        const formData = {
            'idproducto': idproducto.value,
            'prodetalle': prodetalle.getAttribute('value'),
            'pronombre': pronombre.value,
            'procantstock': procantstock.value,
            'precio': proprecio.value,
            'prodeshabilitado': prodeshabilitado.getAttribute('value'),
            'accion': accion
        }

        $.ajax({
            type: "post",
            url: "accion/agregarModProd.php",
            data: formData,

            success: function(response) {
                const datos = (response)
                console.log(datos);
                if (datos != '') {
                    Swal.fire({
                        icon: datos.icono,
                        title: datos.mensaje
                    })
                }
            }

        });
    }
</script>

<?php include_once "./includes/footer.php"; ?>