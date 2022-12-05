<?php

class Producto extends BaseDatos {

  private $idproducto;
  private $pronombre;
  private $prodetalle;
  private $procantstock;
  private $precio;
  private $prodeshabilitado;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->idproducto = null;
    $this->pronombre = '';
    $this->prodetalle = '';
    $this->procantstock = null;
    $this->precio = null;
    $this->prodeshabilitado = null;
  }

  public function setear($idproducto, $pronombre, $prodetalle, $procantstock, $precio, $prodeshabilitado) {
    $this->setIdProducto($idproducto);
    $this->setPronombre($pronombre);
    $this->setProDetalle($prodetalle);
    $this->setProCantStock($procantstock);
    $this->setPrecio($precio);
    $this->setProDeshabilitado($prodeshabilitado);
  }

  public function getIdProducto() {
    return $this->idproducto;
  }
  public function setIdProducto($idproducto) {
    $this->idproducto = $idproducto;
  }

  public function getProNombre() {
    return $this->pronombre;
  }
  public function setProNombre($pronombre) {
    $this->pronombre = $pronombre;
  }

  public function getProDetalle() {
    return $this->prodetalle;
  }
  public function setProDetalle($prodetalle) {
    $this->prodetalle = $prodetalle;
  }

  public function getProCantStock() {
    return $this->procantstock;
  }
  public function setProCantStock($procantstock) {
    $this->procantstock = $procantstock;
  }

  public function getPrecio() {
    return $this->precio;
  }
  public function setPrecio($precio) {
    $this->precio = $precio;
  }

  public function getProDeshabilitado() {
    return $this->prodeshabilitado;
  }
  public function setProDeshabilitado($prodeshabilitado) {
    $this->prodeshabilitado = $prodeshabilitado;
  }

  public function getMsjError() {
    return $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM producto WHERE idproducto = {$this->getIdProducto()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['precio'], $row['prodeshabilitado']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $sql = "
    INSERT INTO producto (pronombre, prodetalle, procantstock, precio, prodeshabilitado) 
    VALUES ('{$this->getProNombre()}', '{$this->getProDetalle()}', {$this->getProCantStock()}, {$this->getPrecio()}," . (($this->getProDeshabilitado() == NULL) ? 'NULL' : "'{$this->getProDeshabilitado()}'") . ")";
   ;
    if ($this->Iniciar()) {
      if ($id = $this->Ejecutar($sql)) {
        $this->setIdProducto($id);

        $resp = true;
      } else {
        $this->setMsjError($this->getError()[2]);
      }
    } else {
      $this->setMsjError($this->getError()[2]);
    }
    return $resp;
  }

  public function modificar() {
    $resp = false;
    $sql = "UPDATE producto SET
      pronombre = '{$this->getProNombre()}',
      prodetalle = '" . str_replace("'", "", $this->getProDetalle()) . "',
      procantstock = {$this->getProCantStock()},
      precio = {$this->getPrecio()},
        prodeshabilitado = " . (($this->getProDeshabilitado() == NULL) ? 'NULL' : "'{$this->getProDeshabilitado()}'") . "
      WHERE idproducto = {$this->getIdProducto()}";
    echo '<pre>';
    var_dump($sql);
    echo '</pre>';
    // echo $sql;
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql) > -1) { // Modificar si hace falta o cambiar el modifcar producto
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
    $sql = "DELETE FROM producto WHERE idproducto= {$this->getIdProducto()}";
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        return true;
      } else {
        $this->setMsjError(" $this->getError()");
      }
    } else {
      $this->setMsjError("$this->getError()");
    }
    return $resp;
  }

  public function listar($parametro = "") {
    $arreglo = array();
    $sql = "SELECT * FROM producto ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $this->Registro()) {
          $obj = new Producto();

          $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['precio'], $row['prodeshabilitado']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }

  public function setearValores($idproducto, $pronombre, $prodetalle, $procantstock, $urlImagen, $precio) {
    $this->setIdProducto($idproducto);
    $this->setPronombre($pronombre);
    $this->setProdetalle($prodetalle);
    $this->setProcantstock($procantstock);
    $this->setPrecio($precio);
  }

  public function newProducto($datos) {
    $objProducto = new Producto();
    if (isset($datos)) {

      $validacion = false;

      $objProducto->setearValores($datos['idproducto'], $datos['pronombre'], $datos['prodetalle'], $datos['procantstock'], $datos['urlimg'], $datos['precio']);

      if ($objProducto->Insertar()) {
        $validacion = true;
      }


      return $validacion;
    }
  }
}
