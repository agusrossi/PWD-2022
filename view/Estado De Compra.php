<?php $title = 'Compra estado';
include_once('../config.php');
include_once('./includes/head.php');
include_once("./includes/navbar.php");
?>

<?php
$data = data_submitted();
$tieneAcceso = $sesion->controlAcceso($data);


if ($tieneAcceso) {

  $objCompraEstado = new AbmCompraEstado();

  $abmCET = new AbmCompraEstadoTipo();
  $estados = $abmCET->buscar(null);
  $colCompras = new AbmCompra();

  $colCompras = $colCompras->buscar(['idusuario' => ($sesion->getObjUsuario()->getIdusuario())]);


?>
  <div class="container pt-5">
    <table class="table" id="estadoCompra">
      <thead>
        <tr>
          <th>compra</th>
          <th>compra estado</th>
          <th>fecha inicial</th>
          <th>fecha fin</th>
          <th>cambiar estado</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($colCompras as $key => $compra) {
          $colCompraEst = $objCompraEstado->buscar(['idcompra' => $compra->getIdCompra()]);
        ?>
          <?php if (isset($colCompraEst)) {
            foreach ($colCompraEst as $compraEst) {
              // $compraEst = $compraEst[0];
          ?>
              <tr style="border-bottom:2px solid white;">
                <td scope="row"><?= $compraEst->getObjCompra()->getIdCompra() ?></td>
                <td><?= $compraEst->getObjCompraEstTipo()->getCetDescripcion() ?></td>
                <td><?= $compraEst->getCeFechaIni() ?></td>
                <td><?= $compraEst->getCeFechaFin() ?></td>
                <td><select idcompra="<?= $compraEst->getObjCompra()->getIdCompra() ?>" class="select-estado-tipo form-select" name="estado" id="">
                    <?php
                    foreach ($estados as $tipoEstado) {
                      if ($tipoEstado->getIdCompraEstTipo() == 1 || $tipoEstado->getIdCompraEstTipo() == 4) {
                        if ($compraEst->getObjCompraEstTipo()->getIdCompraEstTipo() == $tipoEstado->getIdCompraEstTipo()) { ?>
                          <option selected value="<?= $tipoEstado->getIdCompraEstTipo() ?>"><?= $tipoEstado->getCetDescripcion() ?>
                          </option>
                        <?php } else { ?>
                          <option value="<?= $tipoEstado->getIdCompraEstTipo() ?>">
                            <?= $tipoEstado->getCetDescripcion()  ?>
                          </option><?php } ?>
                      <?php  } ?>
                    <?php } ?>
                  </select></td>

              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td colspan="6" style="text-align: center;">No se encontraron compras registrados</td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
  <script>
    $('.select-estado-tipo').change(function(e) {
      $.ajax({
        type: "post",
        url: "accion/cambiarEstadoTipo.php",
        data: {
          'idcompra': this.getAttribute("idcompra"),
          'idcompraestadotipo': this.value
        },
        success: function(response) {
          console.log(response);
        }
      });
      console.log(this.getAttribute("idcompra"));
    });
    $(document).ready(function() {
      $('#estadoCompra').DataTable();
    });
  </script>
<?php
} else {
?>
  <div class="container d-flex justify-content-center align-items-start text-center mt-5">
    <div class="alert alert-danger mt-20vh" role="alert">
      <h4 class="alert-heading">Esta pagina es solo para administradores</h4>
    </div>
  </div>

<?php
};

?>

<?php include_once "./includes/footer.php"; ?>