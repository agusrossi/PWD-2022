<?php
include_once '../config.php';



$data = data_submitted();
$url = $data['url'];


if (isset($data['idrol'])) {
  $_SESSION['rol'] = $data['idrol'];
  header("Location: " . $url);
}
