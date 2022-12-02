
<?php
/* Funcion que submite al arreglo get o post y lo coloca en un arreglo
asociativo; Util para que el proyecto no dependa de si es post o get */
function data_submitted() {
  $arreglo = array();
  if (!empty($_POST)) { //si No esta vacio en method post
    $arreglo = $_POST;
  } elseif (!empty($_GET)) {
    $arreglo = $_GET;
  }
  if (count($arreglo)) {
    // si existen campos vacios, carga null en el arreglo asoci
    foreach ($arreglo as $clave => $valor) {
      if ($valor == "") {
        $arreglo[$clave] = 'null';
      }
    }
  }
  return $arreglo;
}
/***
 * Establecer zona horaria argentina para carga en BD
 */
ini_set("date.timezone", "America/Argentina/Buenos_Aires");


/* Funcion para poner a disponibilidad los objetos dentro del proyecto */
spl_autoload_register(function ($clase) {
  $directorios = array(
    $GLOBALS['ROOT'] . 'model/connection/',
    $GLOBALS['ROOT'] . 'model/',
    $GLOBALS['ROOT'] . 'controller/',
  );



  foreach ($directorios as $directorio) {
    // echo "aqui se incluye" . $directorio . $clase . ".php<br>";

    if (file_exists($directorio . $clase . ".php")) {
      // echo "aqui se incluye" . $directorio . $clase . ".php";
      require_once($directorio . $clase . ".php");

      include_once($directorio . $clase . ".php");
      return;
    }
  }
});

function fecha($dias = 0) {
  date_default_timezone_set("America/Argentina/Buenos_Aires");
  $date = new DateTime('now');

  if ($dias != 0) {
    $date->modify('+' . $dias . ' day');
  }
  $date = $date->format('Y-m-d H:i:s');
  return $date;
}

function strToCamelCase($string, $capitalizeFirstCharacter = false) {
  $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

  if (!$capitalizeFirstCharacter) {
    $str[0] = strtolower($str[0]);
  }

  return $str;
}

?>