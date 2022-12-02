<?php
include_once "../../config.php";
$data = data_submitted();
$abmUs = new AbmUsuario();

// $abmUs->altaBajaUsuario();
$listaUsuarios = $abmUs->listar();
$usuarioEsRol = $abmUs->esRol($sesion);
echo '<pre>';
var_dump($listaUsuarios);
echo '</pre>';
?>



<div class="container d-flex justify-content-center align-items-start text-center mt-5">

    <?php if ($sesion->activa()) { ?>

        <?php if (count($listaUsuarios) > 0) { ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Fecha de baja</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>



                    <?php foreach ($listaUsuarios as $objUsuario) { ?>

                        <?php $textoDeshab = ($objUsuario->getUsDeshabilitado()) ? "class=\"text-black-50\"" : ""; ?>
                        <?php $rolesUsuarioActual = $abmUs->printRoles($objUsuario) ?>

                        <?php
                        $bgcUsuario = "";
                        $disabled = "";

                        if ($objUsuario->getIdUsuario() != $_SESSION['idusuario']) {
                            if (strpos($rolesUsuarioActual, 'administrador') !== false) { // Si el usuario listado es admin
                                $disabled = "disabled";
                            } elseif (strpos($rolesUsuarioActual, 'deposito') !== false and !$usuarioEsRol['administrador']) { // Si el usuario listado es deposito y no soy admin
                                $disabled = "disabled";
                            } elseif (!$usuarioEsRol['administrador'] and !$usuarioEsRol['deposito']) { // Si el usuario listado es miembro y no soy deposito ni admin
                                $disabled = "disabled";
                            }
                        } else {
                            $bgcUsuario = "bg-light";
                        }
                        ?>
                        <?php $textoDeshab = ($objUsuario->getUsDeshabilitado() == null) ? "class=\"text-black-50\"" : ""; ?>
                        <?php $rolesUsuarioActual = $abmUs->printRoles($objUsuario) ?>

                        <?php
                        $bgcUsuario = "";
                        $disabled = "";

                        if ($objUsuario->getIdUsuario() != $_SESSION['idusuario']) {
                            if (strpos($rolesUsuarioActual, 'administrador') !== false) { // Si el usuario listado es admin
                                $disabled = "disabled";
                            } elseif (strpos($rolesUsuarioActual, 'deposito') !== false and !$usuarioEsRol['administrador']) { // Si el usuario listado es deposito y no soy admin
                                $disabled = "disabled";
                            } elseif (!$usuarioEsRol['administrador'] and !$usuarioEsRol['deposito']) { // Si el usuario listado es miembro y no soy deposito ni admin
                                $disabled = "disabled";
                            }
                        } else {
                            $bgcUsuario = "bg-light";
                        }
                        ?>
                        <tr class="<?= $bgcUsuario ?>">
                            <td <?= $textoDeshab ?>><?= $objUsuario->getUsNombre() ?></td>
                            <td <?= $textoDeshab ?>><?= $objUsuario->getUsMail() ?></td>
                            <td <?= $textoDeshab ?>><?= $objUsuario->getUsDeshabilitado() ?></td>
                            <td <?= $textoDeshab ?>><?= $rolesUsuarioActual ?></td>


                            <td>

                                <?php if ($objUsuario->getUsDeshabilitado() != null) { ?>
                                    <a class="btn btn-primary <?= $disabled ?>" title="Editar" href="./editarDatosCliente.php?idu=<?= $objUsuario->getIdUsuario() ?>" role="button"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-danger <?= $disabled ?>" title="Dar de baja" href="./listarUsuario.php?idu=<?= $objUsuario->getIdUsuario() ?>&baja=1" role="button"><i class="fas fa-trash-alt"></i></a>
                                <?php } else { ?>
                                    <a class="btn btn-warning <?= $disabled ?>" title="Reactivar" href="./listarUsuario.php?idu=<?= $objUsuario->getIdUsuario() ?>&baja=0" role="button"><i class="fas fa-redo"></i></a>
                                <?php } ?>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-danger d-flex align-items-center p-4" role="alert">
                <div>
                    <h2>No hay usuarios cargados en el sistema</h2>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="alert alert-danger mt-20vh" role="alert">
            <h4 class="alert-heading">Esta pagina es solo para usuarios registrados</h4>
        </div>
    <?php } ?>

</div>