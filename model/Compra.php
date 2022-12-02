<?php

class Compra extends BaseDatos {

  private $idcompra;
  private $cofecha;
  private $objusuario;
  private $colCompraEstados;
  private $colCompraItems;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->idcompra = null;
    $this->cofecha = '';
    $this->objusuario = null;
    $this->colCompraEstado = [];
    $this->colCompraItems = [];
  }

  public function setear($idcompra, $cofecha, $objusuario) {
    $this->setIdCompra($idcompra);
    $this->setCoFecha($cofecha);
    $this->setObjUsuario($objusuario);
  }

  public function getIdCompra() {
    return  $this->idcompra;
  }
  public function setIdCompra($idcompra) {
    $this->idcompra = $idcompra;
  }

  public function getCoFecha() {
    return  $this->cofecha;
  }
  public function setCoFecha($cofecha) {
    $this->cofecha = $cofecha;
  }

  /**
   * @return Usuario
   */
  public function getObjUsuario() {
    return  $this->objusuario;
  }
  public function setObjUsuario($objusuario) {
    $this->objusuario = $objusuario;
  }

  public function getColCompraEstados() {
    if (empty($this->colCompraEstados)) {
      $ambCE = new AbmCompraEstado();
      $condicionCE['idcompra'] = $this->getIdCompra();
      $colCE = $ambCE->buscar($condicionCE);

      $this->setColCompraEstados($colCE);
    }

    return $this->colCompraEstados;
  }
  public function setColCompraEstados($colCompraEstados) {
    $this->colCompraEstados = $colCompraEstados;
  }

  public function getColCompraItems() {
    if (empty($this->colCompraItems)) {
      $compraItem = new AbmCompraItem();
      $condicion['idcompra'] = $this->getIdCompra();
      $colItem = $compraItem->buscar($condicion);

      $this->setColCompraItems($colItem);
    }

    return $this->colCompraItems;
  }

  public function setColCompraItems($colCompraItems) {
    $this->colCompraItems = $colCompraItems;
  }

  public function getMsjError() {
    return  $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM compra WHERE idcompra = {$this->getIdCompra()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();

          $objUsuario = new Usuario();
          $objUsuario->setIdUsuario($row['idusuario']);
          $objUsuario->cargar();

          $this->setear($row['idcompra'], $row['cofecha'], $objUsuario);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $sql = "INSERT INTO compra (cofecha, idusuario) VALUES ('{$this->getCoFecha()}', {$this->getObjUsuario()->getIdUsuario()})";

    if ($this->Iniciar()) {
      if ($elId = $this->Ejecutar($sql)) {
        $this->setIdCompra($elId);
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
    $sql = "UPDATE compra SET cofecha = '{$this->getCoFecha()}', idusuario = {$this->getObjUsuario()->getIdUsuario()} WHERE idcompra = {$this->getIdCompra()}";
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setMsjError("Tabla->modificar: {$this->getError()}");
      }
    } else {
      $this->setMsjError("Tabla->modificar: {$this->getError()}");
    }
    return $resp;
  }

  public function eliminar() {
    $resp = false;
    $sql = "DELETE FROM compra WHERE idcompra = {$this->getIdCompra()}";
   
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
    $sql = "SELECT * FROM compra ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }

    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $this->Registro()) {
          $obj = new Compra();

          $objusuario = new Usuario();
          $objusuario->setIdUsuario($row['idusuario']);
          $objusuario->cargar();

          $obj->setear($row['idcompra'], $row['cofecha'], $objusuario);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
