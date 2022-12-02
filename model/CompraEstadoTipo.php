<?php

class CompraEstadoTipo extends BaseDatos {

  private $idcompraesttipo;
  private $cetdescripcion;
  private $cetdetalle;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->idcompraesttipo = null;
    $this->cetdescripcion = '';
    $this->cetdetalle = '';
  }

  public function setear($idcompraesttipo, $cetdescripcion, $cetdetalle) {
    $this->setIdCompraEstTipo($idcompraesttipo);
    $this->setCetDescripcion($cetdescripcion);
    $this->setCetDetalle($cetdetalle);
  }

  public function getIdCompraEstTipo() {
    return  $this->idcompraesttipo;
  }
  public function setIdCompraEstTipo($idcompraesttipo) {
    $this->idcompraesttipo = $idcompraesttipo;
  }

  public function getCetDescripcion() {
    return  $this->cetdescripcion;
  }
  public function setCetDescripcion($cetdescripcion) {
    $this->cetdescripcion = $cetdescripcion;
  }

  public function getCetDetalle() {
    return  $this->cetdetalle;
  }
  public function setCetDetalle($cetdetalle) {
    $this->cetdetalle = $cetdetalle;
  }

  public function getMsjError() {
    return  $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = {$this->getIdCompraEstTipo()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();

          $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $sql = "INSERT INTO compraestadotipo ( idcompraestadotipo,cetdescripcion,cetdetalle ) VALUES ({$this->getIdCompraEstTipo()},'{$this->getCetDescripcion()}','{$this->getCetDetalle()}')";

    if ($this->Iniciar()) {
      if ($id = $this->Ejecutar($sql)) {
        $this->setIdCompraEstTipo($id);

        $resp = true;
      } else {
        $this->setMsjError("Tabla->insertar: {$this->getError()[2]}");
      }
    } else {
      $this->setMsjError("Tabla->insertar: {$this->getError()[2]}");
    }
    return $resp;
  }

  public function modificar() {
    $resp = false;
    $sql = "UPDATE compraestadotipo SET cetdescripcion = '{$this->getCetDescripcion()}', cetdetalle = '{$this->getCetDetalle()}' WHERE idcompraestado = {$this->getIdCompraEstTipo()}";
    if ($this->Iniciar()) {

      if ($this->Ejecutar($sql)) {

        $resp = true;
      } else {
        $this->setMsjError("Tabla->modificar: { $this->getError()}");
      }
    } else {
      $this->setMsjError("Tabla->modificar: {$this->getError()}");
    }
    return $resp;
  }

  public function eliminar() {
    $resp = false;
    $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo= {$this->getIdCompraEstTipo()}";
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        return true;
      } else {
        $this->setMsjError("Tabla->eliminar: {$this->getError()}");
      }
    } else {
      $this->setMsjError("Tabla->eliminar: {$this->getError()}");
    }
    return $resp;
  }

  public function listar($parametro = "") {
    $arreglo = array();
    $sql = "SELECT * FROM compraestadotipo ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $this->Registro()) {
          $obj = new CompraEstadoTipo();
          $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
