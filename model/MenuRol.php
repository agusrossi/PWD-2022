<?php

class MenuRol extends BaseDatos{

  private $objmenu;
  private $objrol;
  private $msjerror;

  public function __construct() {
    parent::__construct();
    $this->objmenu = null;
    $this->objrol = null;
  }

  public function setear($objmenu, $objrol) {
    $this->setObjMenu($objmenu);
    $this->setObjRol($objrol);
  }

  /**
   * @return Menu
   */
  public function getObjMenu() {
    return $this->objmenu;
  }
  public function setObjMenu($objmenu) {
    $this->objmenu = $objmenu;
  }

  /**
   * @return Rol
   */
  public function getObjRol() {
    return $this->objrol;
  }
  public function setObjRol($objrol) {
    $this->objrol = $objrol;
  }

  public function getMsjError() {
    return $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $sql = "SELECT * FROM menurol WHERE objmenu = {$this->getObjMenu()}";
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idmenu'], $row['idrol']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$this->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $sql = "INSERT INTO menurol (idmenu, idrol) VALUES ({$this->getObjMenu()->getIdMenu()}, {$this->getObjRol()->getIdRol()})";

    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {

        $resp = true;
      } else {
        $this->setMsjError("Tabla->insertar: {$this->getError()[2]}");
      }
    } else {
      $this->setMsjError("Tabla->insertar: {$this->getError()[2]}");
    }
    return $resp;
  }

  /**
   * Este metodo sirve para modificar el rol que puede usar esta opcion de menu
   * @return void
   */
  public function modificar() {
    $resp = false;
    $sql = "UPDATE menurol SET idrol = {$this->getObjRol()->getIdRol()} WHERE idmenu = {$this->getObjMenu()->getIdMenu()}";
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
    $sql = "DELETE FROM menurol WHERE idmenu={$this->getObjMenu()->getIdMenu()} AND idrol={$this->getObjRol()->getIdRol()}";
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
    $sql = "SELECT * FROM menurol ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $this->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $this->Registro()) {
          $obj = new MenuRol();

          $objMenu = new Menu();
          $objMenu->setIdMenu($row['idmenu']);
          $objMenu->cargar();

          $objRol = new Rol();
          $objRol->setIdRol($row['idrol']);
          $objRol->cargar();

          $obj->setear($objMenu, $objRol);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
