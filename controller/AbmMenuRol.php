<?php

class AbmMenuRol {
  public function abm($datos) {
    $resp = false;
    if ($datos['accion'] == 'editar') {
      if ($this->modificacion($datos)) {
        $resp = true;
      }
    }
    if ($datos['accion'] == 'borrar') {
      if ($this->baja($datos)) {
        $resp = true;
      }
    }
    if ($datos['accion'] == 'nuevo') {
      if ($this->alta($datos)) {
        $resp = true;
      }
    }
    return $resp;
  }
  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
   * @param array $datos
   * @return MenuRol
   */
  private function cargarObjeto($datos) {
    $obj = null;

    if (
      array_key_exists('idmenu', $datos) &&
      array_key_exists('idrol', $datos)
    ) {
      $obj = new MenuRol();

      $objRol = new Rol();
      $objRol->setIdRol($datos['idrol']);
      $objRol->cargar();

      $objMenu = new Menu();
      $objMenu->setIdMenu($datos['idmenu']);
      $objMenu->cargar();

      $obj->setear($objMenu, $objRol);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return MenuRol
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (isset($datos['idmenu']) && isset($datos['idrol'])) {
      $obj = new MenuRol();

      $objRol = new Rol();
      $objRol->setIdRol($datos['idrol']);
      $objRol->cargar();

      $objMenu = new Menu();
      $objMenu->setIdMenu($datos['idmenu']);
      $objMenu->cargar();

      $obj->setear($objMenu, $objRol);
    }
    return $obj;
  }


  /**
   * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
   * @param array $datos
   * @return boolean
   */
  private function seteadosCamposClaves($datos) {
    $resp = false;
    if (isset($datos['idmenu']))
      $resp = true;
    return $resp;
  }

  /**
   * Permite ingresar un registro en la base de datos
   * @param array $datos
   * @return boolean
   */
  public function alta($datos) {
    $resp = false;
    // $datos['idmenu'] = null;
    $obj = $this->cargarObjeto($datos);

    if ($obj != null and $obj->insertar()) {
      $resp = true;
    }

    return $resp;
  }

  /**
   * permite eliminar un objeto 
   * @param array $datos
   * @return boolean
   */
  public function baja($datos) {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjetoConClave($datos);
      if ($obj != null and $obj->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  /**
   * permite modificar un objeto
   * @param array $datos
   * @return boolean
   */
  public function modificacion($datos) {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjeto($datos);
      if ($obj != null and $obj->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  /**
   * permite buscar un objeto
   * @param array $datos
   * @return array
   */
  public function buscar($datos) {
    $where = " true ";
    if ($datos != null) {
      if (isset($datos['idmenu']))
        $where .= " and idmenu  = {$datos['idmenu']}";
      if (isset($datos['idrol']))
        $where .= " and idrol = {$datos['idrol']}";
    }
    $obj = new MenuRol();
    return $obj->listar($where);
  }

  // me devuelve un array con los menu de ese rol
  function menuRol($sesion) {
    return $this->buscar(['idrol' => $sesion->getRolActual()]);
  }
  // function controlAcceso() {

  //   $resp = false;
  //   $data = data_submitted();

  //   if (isset($data['idmenu'])) {
  //     $abmMenuRol = new AbmMenuRol;
  //     $col = $abmMenuRol->buscar(['idmenu' => $data['idmenu'], 'idrol' => $_SESSION['rol']]);

  //     if (count($col) != 0) {
  //       $resp = true;
  //     }
  //   }
  //   return $resp;
  // }
}
