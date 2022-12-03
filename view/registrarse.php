<?php $title = 'index';

include_once './includes/head.php'; ?>
<?php include_once "./includes/navbar.php"; ?>


<div class="container d-flex justify-content-center align-items-start text-center mt-20vh">

    <div class="container border border-1  p-3 w-50 mx-auto mt-20vh">
        <h3 class="mb-3 font-weight-normal">Registrarse</h3>
        <form id="form-registro" class="needs-validation p-3 w-50 mx-auto mt-20vh" action="accion/accionRegistrarse.php" method="post" novalidate>



            <!-- Usuario -->
            <div class="form-group mb-3">
                <label for="usnombre">Nombre de usuario</label>
                <input type="text" name="usnombre" class="form-control" id="usnombreN" required>
            </div>

            <!-- Mail -->
            <div class="form-group mb-3">
                <label for="usmail">Mail</label>
                <input type="email" name="usmail" class="form-control" id="usmailN" required>
            </div>

            <!-- Contraseña -->
            <div class="form-group mb-3">
                <label for="uspass">Contraseña</label>
                <input type="password" name="uspass" class="form-control" id="uspassN">
            </div>

            <!-- Registrar -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3">Registrar</button>
            </div>

        </form>
    </div>
</div>

<script>
    $("#form-registro").submit(function(event) {
        event.preventDefault();
        var formData = {
            usnombre: this.usnombreN.value,
            usmail: this.usmailN.value,
            uspass: this.uspassN.value
        };


        $.ajax({
            type: "post",
            url: "accion/accionRegistrarse.php",
            data: formData,

            success: function(response) {
                const datos = JSON.parse(response)
                if (datos != '') {
                    Swal.fire({
                        icon: datos.icono,
                        title: datos.mensaje
                    })
                }
                console.log(datos.icono);
                if (datos.icono == 'success') {
                    console.log('entra');

                }
            }
        });

    });
</script>
<?php include_once 'includes/footer.php' ?>