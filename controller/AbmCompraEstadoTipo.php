<?php

class AbmCompraEstadoTipo {
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
   * @return CompraEstadoTipo
   */
  private function cargarObjeto($datos) {
    $obj = null;

    if (
      array_key_exists('idcompraestadotipo', $datos) &&
      array_key_exists('catdescripcion', $datos) &&
      array_key_exists('cetdetalle', $datos)
    ) {
      $obj = new CompraEstadoTipo();

      $obj->setear($datos['idcompraestadotipo'], $datos['catdescripcion'], $datos['cetdetalle']);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return CompraEstadoTipo
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (isset($datos['idcompraestadotipo'])) {
      $obj = new CompraEstadoTipo();
      $obj->setear($datos['idcompraestadotipo'], null, null);
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
    if (isset($datos['idcompraestadotipo']))
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
    $datos['idcompraestadotipo'] = null;
    $obj = $this->cargarObjeto($datos);

    if ($obj != null && $obj->insertar()) {
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
      if ($obj != null && $obj->eliminar()) {
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
      if ($obj != null && $obj->modificar()) {
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
      if (isset($datos['idcompraestadotipo']))
        $where .= " and idcompraestadotipo  = {$datos['idcompraestadotipo']}";
      if (isset($datos['cetdescripcion']))
        $where .= " and cetdescripcion = '{$datos['cetdescripcion']}'";
      if (isset($datos['cetdetalle']))
        $where .= " and cetdetalle = '{$datos['cetdetalle']}'";
    }
    $obj = new CompraEstadoTipo();
    return $obj->listar($where);
  }
}
