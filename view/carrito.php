<?php $title = 'carrito';
include_once "./includes/navbar.php";
include_once './includes/headSegura.php';
$compra = null;
$abmCompra = new AbmCompra();
$compra = $abmCompra->getUltimaCompra($sesion->getObjUsuario()->getIdUsuario());
if (!empty($compra) && !empty($compra->getColCompraItems())) {
    if (empty($compra->getColCompraEstados())) {

?>

        <div class="container" style="max-width:650px;">
            <ol class="list-group list-group">

                <?php foreach ($compra->getColCompraItems() as $compraItem) { ?>

                    <li id="item-<?= $compraItem->getIdCompraItem() ?>" class="list-group-item d-flex justify-content-between align-items-start">
                        <img width="100" src="assets/<?= $compraItem->getObjProducto()->getProDetalle() ?> " alt="">
                        <div class="ms-2 me-auto">

                            <div class="fw-bold">
                                <?= $compraItem->getObjProducto()->getProNombre() ?>
                            </div>

                        </div>

                        <span class="badge bg-primary rounded-pill"> <?= $compraItem->getCiCantidad() ?></span>

                        <button class="btn btn-outline-danger ms-3 botonBorrar" type="button" value='<?= $compraItem->getIdCompraItem() ?>'><i class="bi bi-trash-fill"></i></button>

                    </li>
                <?php
                }

                ?>
            </ol>

            <div class="d-flex justify-content-end mt-5">

                <a class="btn btn-primary me-3" type="button" href="accion/cambiarEstado.php?accion=comprar&idcompra= <?= $compra->getIdcompra() ?>">Comprar</a>
                <a class="btn btn-danger " type="button" href="accion/cambiarEstado.php?accion=cancelar&idcompra= <?= $compra->getIdcompra() ?>">Cancelar</a>

            </div>
        </div>

    <?php
    }
} else {
    ?>
    <h3 class="text-center">carrito vacio</h3>
<?php
}

?>
<script>
    $('.botonBorrar').click(function(e) {
        $.ajax({
            type: "post",
            url: "accion/cambiarEstado.php",
            data: {
                'accion': 'borrarItem',
                'idcompraitem': this.value
            },

        });
        $('#item-' + this.value).remove();
    });
</script>
<?php include_once 'includes/footer.php' ?>