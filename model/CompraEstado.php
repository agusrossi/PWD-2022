<?php

class CompraEstado extends BaseDatos {

  private $idcompraestado;
  private $objcompra;
  private $objcompraesttipo;
  private $cefechaini;
  private $cefechafin;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->idcompraestado = null;
    $this->objcompra = null;
    $this->objcompraesttipo = null;
    $this->cefechaini = '';
    $this->cefechafin = '';
  }

  public function setear($idcompraestado, $objcompra, $objcompraesttipo, $cefechaini, $cefechafin) {
    $this->setIdCompraEstado($idcompraestado);
    $this->setObjCompra($objcompra);
    $this->setObjCompraEstTipo($objcompraesttipo);
    $this->setCeFechaini($cefechaini);
    if ($cefechafin === '0000-00-00 00:00:00') {
      $cefechafin = "null";
    }
    $this->setCeFechaFin($cefechafin);
  }

  public function getIdCompraEstado() {
    return  $this->idcompraestado;
  }
  public function setIdCompraEstado($idcompraestado) {
    $this->idcompraestado = $idcompraestado;
  }

  /**
   * @return Compra
   */
  public function getObjCompra() {
    return  $this->objcompra;
  }
  public function setObjCompra($objcompra) {
    $this->objcompra = $objcompra;
  }

  /**
   * @return CompraEstadoTipo
   */
  public function getObjCompraEstTipo() {
    return  $this->objcompraesttipo;
  }
  public function setObjCompraEstTipo($objcompraesttipo) {
    $this->objcompraesttipo = $objcompraesttipo;
  }

  public function getCeFechaIni() {
    return  $this->cefechaini;
  }
  public function setCeFechaIni($cefechaini) {
    $this->cefechaini = $cefechaini;
  }

  public function getCeFechaFin() {
    return  $this->cefechafin;
  }
  public function setCeFechaFin($cefechafin) {
    $this->cefechafin = $cefechafin;
  }

  public function getMsjError() {
    return  $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }


  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM compraEstado WHERE idcompraestado = {$this->getIdCompraEstado()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();

          $objcompra = new Compra();
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $objCompraEstadoTipo = new CompraEstadoTipo();
          $objCompraEstadoTipo->setIdCompraEstTipo($row['compraestadotipo']);
          $objCompraEstadoTipo->cargar();

          $this->setear($row['idcompraestado'], $objcompra, $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini, cefechafin) VALUES ({$this->getObjCompra()->getIdCompra()}, {$this->getObjCompraEstTipo()->getIdCompraEstTipo()}, '{$this->getCeFechaIni()}', '{$this->getCeFechaFin()}')";

    if ($this->Iniciar()) {
      if ($id = $this->Ejecutar($sql)) {
        $this->setIdCompraEstado($id);
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
    $sql = "UPDATE compraestado SET 
      idcompra = {$this->getObjCompra()->getIdCompra()},
      idcompraestadotipo = {$this->getObjCompraEstTipo()->getIdCompraEstTipo()},
      cefechaini = '{$this->getCeFechaIni()}',
      cefechafin=" . (($this->getCeFechaFin() == '') ? "NULL" : "'{$this->getCeFechaFin()}'") . "
      WHERE idcompraestado = {$this->getIdCompraEstado()}";

    // echo $sql;
    if ($this->Iniciar()) {
      // echo "ASD";
      if ($this->Ejecutar($sql)) {
        $resp = true;
        // echo "ad";
      } else {
        // echo "ASD2222";

        $this->setMsjError("Tabla->modificar: {$this->getError()}");
      }
    } else {

      $this->setMsjError("Tabla->modificar: {$this->getError()}");
    }
    return $resp;
  }

  public function eliminar() {
    $resp = false;
    $sql = "DELETE FROM compraestado WHERE idcompraestado = {$this->getIdCompraEstado()}";
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
    $sql = "SELECT * FROM compraestado ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
   
    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $this->Registro()) {
          $obj = new CompraEstado();

          $objcompra = new Compra();
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $objcompraesttipo = new CompraEstadoTipo();
          $objcompraesttipo->setIdCompraEstTipo($row['idcompraestadotipo']);
          $objcompraesttipo->cargar();

          $obj->setear($row['idcompraestado'], $objcompra, $objcompraesttipo, $row['cefechaini'], $row['cefechafin']);

          array_push($arreglo, $obj);
        }
      }
    }
    return $arreglo;
  }
}
