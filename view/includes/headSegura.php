<?php include_once "../config.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <!-- Bootstrap CSS -->
  <link href="./assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

  <!-- CSS -->
  <link rel="stylesheet" href="./assets/css/main.css">

  <!-- libreria jQuery_Easyui -->
  <link rel="stylesheet" type="text/css" href="assets/jq_easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="assets/jq_easyui/themes/icon.css">
  <link rel="stylesheet" type="text/css" href="assets/jq_easyui/themes/color.css">
  <link rel="stylesheet" type="text/css" href="assets/jq_easyui/demo/demo.css">
  <script type="text/javascript" src="assets/jq_easyui/jquery.min.js"></script>
  <script type="text/javascript" src="assets/jq_easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="https://www.jeasyui.com/easyui/datagrid-detailview.js"></script>




</head>
<?php
$res = $sesion->tienePermiso();
if (!$res) {
  header("Location: indexIns.php?error=4");
}
?>

<body>