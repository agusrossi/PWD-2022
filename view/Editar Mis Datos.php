<?php $title = 'Editar Datos';
include_once('../config.php');
include_once './includes/head.php';
include_once "./includes/navbar.php";
?>
<?php
$data = data_submitted();
$tieneAcceso = $sesion->controlAcceso($data);
if ($tieneAcceso) { ?>
   
    <div class="container d-flex justify-content-center align-items-start text-center mt-20vh">

        <div class="container border border-1  p-3 w-50 mx-auto mt-20vh">

            <form id="form-cambioDatos" class="needs-validation p-3 w-50 mx-auto mt-20vh" action="accion/accionCambiarDatos.php" method="post" novalidate>



                <!-- Usuario -->
                <div class="form-group mb-3">
                    <label for="usnombre">Nombre de usuario</label>
                    <input style="color:black;" type="text" name="usnombre" class="form-control" id="usnombreN" value="
                    <?= $sesion->getObjUsuario()->getUsNombre() ?>">
                </div>

                <!-- Mail -->
                <div class="form-group mb-3">
                    <label for="usmail">Mail</label>
                    <input type="email" name="usmail" class="form-control" id="usmailN" value="
                    <?= $sesion->getObjUsuario()->getUsMail() ?>" required>
                </div>

                <!-- Contraseña -->
                <div class='form-group mb-3'></div>
                <label for="uspass">Contraseña</label>
                <div class="input-group ">
                    <input type="password" name="uspass" class="form-control" id="id_password" value="
                    <?= $sesion->getObjUsuario()->getUsPass() ?>">
                    <button class="btn border border-1" type="button" id='buttonPassword' ><i class="far fa-eye" id="togglePassword"></i></button>


                </div>



                <!-- Registrar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-primary mt-3">Registrar</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const buttonPassword = document.querySelector('#buttonPassword');
        const password = document.querySelector('#id_password');

        buttonPassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            togglePassword.classList.toggle('fa-eye-slash');
        });



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
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#id_password');

            togglePassword.addEventListener('click', function(e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });

        });
    </script>



<?php } else { ?>
    <div class="container d-flex justify-content-center align-items-start text-center mt-5">
        <div class="alert alert-danger mt-20vh" role="alert">
            <h4 class="alert-heading">Esta pagina es solo para clientes</h4>
        </div>
    </div>

<?php } ?>



<?php include_once "./includes/footer.php"; ?>