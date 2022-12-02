<?php

class CompraItem extends BaseDatos {

  private $idcompraitem;
  private $objproducto;
  private $objcompra;
  private $cicantidad;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->idcompraitem = null;
    $this->objproducto = null;
    $this->objcompra = null;
    $this->cicantidad = null;
  }

  public function setear($idcompraitem, $objproducto, $objcompra, $cicantidad) {
    $this->setIdCompraItem($idcompraitem);
    $this->setObjProducto($objproducto);
    $this->setObjCompra($objcompra);
    $this->setCiCantidad($cicantidad);;
  }

  public function getIdCompraItem() {
    return $this->idcompraitem;
  }
  public function setIdCompraItem($idcompraitem) {
    $this->idcompraitem = $idcompraitem;
  }

  /**
   * @return Producto
   */
  public function getObjProducto() {
    return $this->objproducto;
  }
  public function setObjProducto($objproducto) {
    $this->objproducto = $objproducto;
  }

  /**
   * @return Compra
   */
  public function getObjCompra() {
    return $this->objcompra;
  }
  public function setObjCompra($objcompra) {
    $this->objcompra = $objcompra;
  }

  public function getCiCantidad() {
    return $this->cicantidad;
  }
  public function setCiCantidad($cicantidad) {
    $this->cicantidad = $cicantidad;
  }


  public function getMsjError() {
    return  $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM compraitem WHERE idcompraitem = {$this->getIdCompraItem()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();

          $objproducto = new Producto();
          $objproducto->setIdProducto($row['idproducto']);
          $objproducto->cargar();

          $objcompra = new Compra;
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $this->setear($row['idcompraitem'], $objproducto, $objcompra, $row['cicantidad']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) VALUES ({$this->getObjProducto()->getIdProducto()}, {$this->getObjCompra()->getIdCompra()}, {$this->getCiCantidad()})";

    if ($this->Iniciar()) {
      if ($elId = $this->Ejecutar($sql)) {
        $this->setIdCompraItem($elId);

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
    $sql = "UPDATE compraitem SET idproducto = {$this->getObjProducto()->getIdProducto()}, idcompra = {$this->getObjCompra()->getIdcompra()}, cicantidad = {$this->getCiCantidad()} WHERE idcompraitem = {$this->getIdCompraItem()}";
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
    $sql = "DELETE FROM compraitem WHERE idcompraitem= {$this->getIdCompraItem()}";
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
    $sql = "SELECT * FROM compraitem ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }

    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $this->Registro()) {
          $obj = new CompraItem();

          $objcompra = new Compra();
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $objproducto = new Producto();
          $objproducto->setIdProducto($row['idproducto']);
          $objproducto->cargar();

          $obj->setear(
            $row['idcompraitem'],
            $objproducto,
            $objcompra,
            $row['cicantidad']
          );

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
