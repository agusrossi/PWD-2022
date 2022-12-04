<?php $title = 'comprar';
include_once './includes/headSegura.php';

include_once "./includes/navbar.php";

?>

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

        if (($rolActual == 2) || ($producto->getProDeshabilitado() == null && $rolActual != 2)) { // Si el rol es deposito muestro todos los productos, si es otro rol y no esta deshabilitado tambien muestra
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
                    <?php
                    if ($producto->getProCantStock() > 0) {
                    ?>
                      <p style="color: grey;">Stock disponible: <?= $producto->getProCantStock()  ?> </p>

                    <?php
                    } else {
                    ?>
                      <p style="color: grey;">Stock disponible: <span style="color: red;">sin stock</span> </p>
                    <?php
                    }
                    ?>
                  </div>
                </div>
                <!-- accion producto-->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                  <div class="text-center">
                    <form action="accion/agregarProducto.php" method="POST">
                      <input type="hidden" id="idproducto" name="idproducto" value="<?= $producto->getIdProducto()  ?>">
                      <input type="hidden" id="idusuario" name="idusuario" value="<?= $sesion->getObjUsuario()->getIdUsuario() ?>">
                      <div class="mb-3">
                        <label for="cicantidad">Ingrese la cantidad</label>
                        <input id="cicantidad" name="cicantidad" type="number" min="0" style="width:60px;">
                      </div>

                      <button type="submit" class="btn btn-outline-dark mt-auto btnAnadir agregarCarrito">Agregar al carrito</button>
                    </form>
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
  $("form").submit(function(event) {

    var formData = {
      idproducto: this.idproducto.value,
      idusuario: this.idusuario.value,
      cicantidad: this.cicantidad.value,
    };


    $.ajax({
      type: "post",
      url: "accion/agregarProducto.php",
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
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
    this.cicantidad.value = null;
    event.preventDefault();
    setTimeout(() => {
      location.reload();
    }, 2000);

  });
</script>
<?php include_once 'includes/footer.php' ?>