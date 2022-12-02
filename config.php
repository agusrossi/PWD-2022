<?php

header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO = 'PWD-2022';

//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";
// $INICIO = "../View/comprar.php";

include_once($ROOT . 'util/funciones.php');

$GLOBALS['ROOT'] = $ROOT;

$sesion = new Session();

