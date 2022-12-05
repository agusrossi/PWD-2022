<?php $title = 'administrar usuarios';
include_once('../config.php');
include_once './includes/head.php';
include_once "./includes/navbar.php";
?>
<?php
$data = data_submitted();
$tieneAcceso = $sesion->controlAcceso($data);
if ($tieneAcceso) { ?>
  <?php
  $objUsuario = new AbmUsuario();
  $objUsuarioRol = new AbmUsuarioRol();
  $colUsuarios = $objUsuario->buscar(null);
  ?>
  <div class="container pt-5">

    <table class="table" id="modificarUsuario">

      <thead>
        <tr>
          <th>Id Usuario</th>
          <th>Nombre</th>
          <th>Contraseña</th>
          <th>Mail</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($colUsuarios)) {
          foreach ($colUsuarios as $key => $usuario) {
            $roles = $objUsuarioRol->buscar(['idusuario' => $usuario->getIdUsuario()]);
        ?>
            <tr style="border-bottom:2px solid white;">
              <td><?= $usuario->getIdUsuario() ?></td>
              <td><?= $usuario->getUsNombre() ?></td>
              <td><?= $usuario->getUsPass() ?></td>
              <td><?= $usuario->getUsMail() ?></td>
              <td><?php foreach ($roles as $rol) {
                    echo ($rol->getobjrol()->getrodescripcion() . "\n");
                  } ?>
              </td>

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
                        <h1 class="modal-title fs-5" id="editar<?= $key ?>Label">Editar usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form id="form-modificar" class="needs-validation p-3 w-50 mx-auto mt-20vh" action="#" method="post" novalidate>

                          <!-- id usuario -->
                          <div class="form-group mb-3">
                            <label for="idUser">id Usario</label>
                            <input type="idUser" name="idUser" class="form-control" id="idUser<?= $key ?>" value='<?= $usuario->getIdUsuario() ?>' disabled>
                          </div>
                          <!-- nombre -->
                          <div class="form-group mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre<?= $key ?>" value="<?= $usuario->getUsNombre() ?>" alt="" height="100" required>
                          </div>
                          <!-- Contraseña -->
                          <div class="form-group mb-3">
                            <label for="contraseña">Contraseña</label>
                            <input type="password" name="contraseña" class="form-control" id="contraseña<?= $key ?>" value='<?= $usuario->getUsPass() ?>' required>
                          </div>

                          <!-- Cantidad de stock -->
                          <div class="form-group mb-3">
                            <label for="mail">Mail</label>
                            <input type="mail" name="mail" class="form-control" id="mail<?= $key ?>" value='<?= $usuario->getUsMail() ?>' required>
                          </div>

                          <!-- rol -->
                          <h6>Seleccionar Rol</h6>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Administrador</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">Deposito</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                            <label class="form-check-label" for="inlineCheckbox3">Cliente</label>
                          </div>
                          <!-- Deshabilitado -->


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
    $('#modificarUsuario').DataTable();
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