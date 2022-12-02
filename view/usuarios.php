<?php $title = 'Administrar usuarios';
include_once('../config.php');
include_once './includes/head.php';
include_once "./includes/navbar.php";
?>
<?php
$data = data_submitted();
$tieneAcceso = $sesion->controlAcceso($data);
if ($tieneAcceso) { ?>
  <h3> tiene permiso para esta pag</h3>
  <div class='container '>

    <table id="dg" title="Control Usuarios" class="easyui-datagrid  " style="width:950px;height:500px ; " url="accion/listarUsuarios.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
      <thead>
        <tr>
          <th field="idusuario" width="20">Id</th>
          <th field="usnombre" width="50">Nombre</th>
          <th field="uspass" width="120">password</th>
          <th field="usmail" width="100">Email</th>
          <th field="usdeshabilitado" width="70">Baja</th>
        </tr>
      </thead>
    </table>
    <div id="toolbar">
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Crear Usuarios</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Usuario</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar</a>
    </div>

    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
      <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h4 class="text-warning "> Datos Usuario</h4>
        <div style="margin-bottom:10px">
          <input name="usnombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
          <input name="uspass" class="easyui-textbox" required="true" label="Password:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
          <input name="usmail" class="easyui-textbox" required="true" label="email:" style="width:100%">
        </div>
        <div>
          <input name="usdeshabilitado" type="hidden">
          <!-- <input name="usdeshabilitado" value='usdeshabilitado' type="hidden">  -->
        </div>
        <div>
          <input name="idusuario" value="idusuario" type="hidden">
        </div>
      </form>
    </div>
    <div id="dlg-buttons">
      <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Aceptar</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <script type="text/javascript">
      var url;

      function newUser() {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Crear Usuario');
        $('#fm').form('clear');
        url = 'accion/newUsuario.php';
      }

      function editUser() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
          $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Usuario');
          $('#fm').form('load', row);
          url = 'accion/modUsuario.php';
        }
      }

      function saveUser() {

        $('#fm').form('submit', {
          url: url,
          iframe: false,
          onSubmit: function() {
            return $(this).form('validate');
          },
          success: function(result) {
            var result = eval('(' + result + ')');

            if (!result.respuesta) {
              // alert("nombre repetido");
              $.messager.show({
                title: 'Error',
                msg: result.errorMsg
              });

            } else {
              $('#dlg').dialog('close'); // close the dialog
              $('#dg').datagrid('reload'); // reload the user data
            }
          }
        });
      }



      function destroyUser() {
        var row = $('#dg').datagrid('getSelected');
        console.log(row);
        if (row) {
          $.messager.confirm('Cambiar', ' cambiar estado de usuario??', function(r) {
            if (r) {
              $('#fm').form('load', row);
              url = 'accion/bajaUsuario.php';
              $('#fm').form('submit', {
                url: url,
                iframe: false,
                onSubmit: function() {
                  return $(this).form('validate');
                },
                success: function(result) {
                  var result = eval('(' + result + ')');
                  if (result.errorMsg) {
                    $.messager.show({
                      title: 'Error',
                      msg: result.errorMsg
                    });
                  } else {
                    $('#dg').datagrid('reload'); // reload the menu data
                  }
                }
              });
            }
          });
        }
      }
    </script>
  </div>
<?php } else { ?>
  <div class="container d-flex justify-content-center align-items-start text-center mt-5">
    <div class="alert alert-danger mt-20vh" role="alert">
      <h4 class="alert-heading">Esta pagina es solo para administradores</h4>
    </div>
  </div>

<?php } ?>



<?php include_once "./includes/footer.php"; ?>