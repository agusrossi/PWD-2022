<?php

class Menu extends BaseDatos {

  private $idmenu;
  private $menombre;
  private $medescripcion;
  private $objmepadre;
  private $medeshabilitado;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->idmenu = null;
    $this->menombre = '';
    $this->medescripcion = '';
    $this->objmepadre = null;
    $this->medeshabilitado = '';
  }

  public function setear($idmenu, $menombre, $meDescrip, $objmepadre, $medeshabilitado) {
    $this->setIdMenu($idmenu);
    $this->setMeNombre($menombre);
    $this->setMeDescripcion($meDescrip);
    $this->setObjMePadre($objmepadre);
    $this->setMeDeshabilitado($medeshabilitado);
  }

  public function getIdMenu() {
    return $this->idmenu;
  }
  public function setIdMenu($idmenu) {
    $this->idmenu = $idmenu;
  }

  public function getMeNombre() {
    return $this->menombre;
  }
  public function setMeNombre($menombre) {
    $this->menombre = $menombre;
  }

  public function getMeDescripcion() {
    return $this->medescripcion;
  }
  public function setMeDescripcion($meDescrip) {
    $this->medescripcion = $meDescrip;
  }

  /**
   * @return Menu
   */
  public function getObjMePadre() {
    return $this->objmepadre;
  }
  public function setObjMePadre($idPadre) {
    $this->objmepadre = $idPadre;
  }

  public function getMeDeshabilitado() {
    return $this->medeshabilitado;
  }
  public function setMeDeshabilitado($meDeshabli) {
    $this->medeshabilitado = $meDeshabli;
  }

  public function getMsjError() {
    return $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM menu WHERE idmenu = {$this->getIdMenu()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();

          if ($row['idpadre'] != null) {
            $objMenuPadre = new Menu();
            $objMenuPadre->setIdMenu($row['idpadre']);
            $objMenuPadre->cargar();
          } else {
            $objMenuPadre = null;
          }

          $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objMenuPadre, $row['medeshabilitado']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    if ($this->getObjMePadre() != null) {
      $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES ('{$this->getMeNombre()}','{$this->getMeDescripcion()}',{$this->getObjMePadre()->getIdMenu()},'{$this->getMeDeshabilitado()}')";
    } else {
      $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES ('{$this->getMeNombre()}','{$this->getMeDescripcion()}','{NULL}','{NULL}')";
    }
    // $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES ('{$this->getMeNombre()}','{$this->getMeDescripcion()}',{$this->getObjMePadre()->getIdMenu()},'{$this->getMeDeshabilitado()}')";

    if ($this->Iniciar()) {
      if ($elId = $this->Ejecutar($sql)) {
        $this->setIdMenu($elId);

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
    if ($this->getMeDeshabilitado() != NULL) {
      $sql = "UPDATE menu SET 
    menombre='{$this->getMeNombre()}',
    medescripcion='{$this->getMeDescripcion()}',
    idpadre={$this->getObjMePadre()->getIdMenu()},
    -- medeshabilitado=" . (($this->getMeDeshabilitado() == 'null') ? null : "'{$this->getMeDeshabilitado()}'") . ",
    medeshabilitado= '{$this->getMeDeshabilitado()}' 
    WHERE idmenu = {$this->getIdMenu()}";
    } else {
      $sql = "UPDATE menu SET 
    menombre='{$this->getMeNombre()}',
    medescripcion='{$this->getMeDescripcion()}',
    idpadre={$this->getObjMePadre()->getIdMenu()},
    -- medeshabilitado=" . (($this->getMeDeshabilitado() == 'null') ? null : "'{$this->getMeDeshabilitado()}'") . ",
    medeshabilitado= null 
    WHERE idmenu = {$this->getIdMenu()}";
    }

    // $sql = "UPDATE menu SET 
    //   menombre='{$this->getMeNombre()}',
    //   medescripcion='{$this->getMeDescripcion()}',
    //   idpadre={$this->getObjMePadre()->getIdMenu()},
    //   medeshabilitado=" . (($this->getMeDeshabilitado() == '') ? "NULL" : "'{$this->getMeDeshabilitado()}'") . ",
    //   WHERE idmenu = {$this->getIdMenu()}";

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
    $sql = "DELETE FROM menu WHERE idmenu={$this->getIdMenu()}";
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
    $sql = "SELECT * FROM menu ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $this->Registro()) {
          $obj = new Menu();

          if ($row['idpadre'] != null) {
            $objMenuPadre = new Menu();
            $objMenuPadre->setIdMenu($row['idpadre']);
            $objMenuPadre->cargar();
          } else {
            $objMenuPadre = null;
          }

          $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objMenuPadre, $row['medeshabilitado']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
