<?php $title = 'Administrar Menus';
include_once('../config.php');
include_once './includes/head.php';
include_once "./includes/navbar.php";
?>
<?php
$data = data_submitted();
$tieneAcceso = $sesion->controlAcceso($data);
if ($tieneAcceso) { ?>
    <h3> tiene permiso para esta pag</h3>
    <h4>PROXIMAMENTE LISTA MENUS</h4>
<?php } else { ?>
    <div class="container d-flex justify-content-center align-items-start text-center mt-5">
        <div class="alert alert-danger mt-20vh" role="alert">
            <h4 class="alert-heading">Esta pagina es solo para administradores</h4>
        </div>
    </div>

<?php } ?>



<?php include_once "./includes/footer.php"; ?>