<?php

class AbmCompraEstado {
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
   * @return CompraEstado
   */
  private function cargarObjeto($datos) {
    $obj = null;
    if (
      array_key_exists('idcompraestado', $datos) &&
      array_key_exists('idcompra', $datos) &&
      array_key_exists('idcompraestadotipo', $datos) &&
      array_key_exists('cefechaini', $datos) &&
      array_key_exists('cefechafin', $datos)
    ) {
      $obj = new CompraEstado();

      $objCompra = new Compra();
      $objCompra->setIdCompra($datos['idcompra']);
      $objCompra->cargar();

      $objEstTipo = new CompraEstadoTipo();
      $objEstTipo->setIdCompraEstTipo($datos['idcompraestadotipo']);
      $objEstTipo->cargar();

      $obj->setear($datos['idcompraestado'], $objCompra, $objEstTipo, $datos['cefechaini'], $datos['cefechafin']);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return CompraEstado
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (isset($datos['idcompraestado'])) {
      $obj = new CompraEstado();
      $obj->setear($datos['idcompraestado'], null, null, null, null);
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
    if (isset($datos['idcompraestado']))
      $resp = true;
    return $resp;
  }

  /**
   * ingresa un registro en la base de datos
   * @param array $datos
   * @return boolean
   */
  public function alta($datos) {
    $resp = false;
    $datos['idcompraestado'] = null;
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
    if ($datos <> NULL) {
      if (isset($datos['idcompraestado']))
        $where .= " and idcompraestado  = {$datos['idcompraestado']}";
      if (isset($datos['idcompra']))
        $where .= " and idcompra = {$datos['idcompra']}";
      if (isset($datos['idcompraestadotipo']))
        $where .= " and idcompraestadotipo = {$datos['idcompraestadotipo']}";
      if (isset($datos['cefechaini']))
        $where .= " and cefechaini = '{$datos['cefechaini']}'";
      if (isset($datos['cefechafin']))
        $where .= " and cefechafin = '{$datos['cefechafin']}'";
    }
    $obj = new CompraEstado();
    return $obj->listar($where);
  }
}
