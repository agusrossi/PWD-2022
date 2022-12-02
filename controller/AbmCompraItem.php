<?php

class AbmCompraItem {
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
   * @return CompraItem
   */
  private function cargarObjeto($datos) {
    $obj = null;

    if (
      array_key_exists('idcompraitem', $datos) &&
      array_key_exists('idproducto', $datos) &&
      array_key_exists('idcompra', $datos) &&
      array_key_exists('cicantidad', $datos)
    ) {
      $obj = new CompraItem();

      $objProd = new Producto();
      $objProd->setIdProducto($datos['idproducto']);
      $objProd->cargar();

      $objCompra = new Compra();
      $objCompra->setIdCompra($datos['idcompra']);
      $objCompra->cargar();

      $obj->setear($datos['idcompraitem'], $objProd, $objCompra, $datos['cicantidad']);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return CompraItem
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (isset($datos['idcompraitem'])) {
      $obj = new CompraItem();
      $obj->setear($datos['idcompraitem'], null, null, null, null);
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
    if (isset($datos['idcompraitem']))
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
    $datos['idcompraitem'] = null;
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
      if (isset($datos['idcompraitem']))
        $where .= " and idcompraitem  = {$datos['idcompraitem']}";
      if (isset($datos['idproducto']))
        $where .= " and idproducto = {$datos['idproducto']}";
      if (isset($datos['idcompra']))
        $where .= " and idcompra = {$datos['idcompra']}";
      if (isset($datos['cicantidad']))
        $where .= " and cicantidad = {$datos['cicantidad']}";
    }
    $obj = new CompraItem;

    return $obj->listar($where);
  }
}
