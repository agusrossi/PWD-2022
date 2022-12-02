<?php

class AbmCompra {
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
   * Retorna null si no se cargo el objeto
   * @param array $datos
   * @return Compra
   */
  private function cargarObjeto($datos) {
    $objCompra = null;

    if (
      array_key_exists('idcompra', $datos) &&
      array_key_exists('cofecha', $datos) &&
      array_key_exists('idusuario', $datos)
    ) {
      $objCompra = new Compra();

      $objUsuario = new Usuario();
      $objUsuario->setIdUsuario($datos['idusuario']);
      $objUsuario->cargar();

      $objCompra->setear($datos['idcompra'], $datos['cofecha'], $objUsuario);
    }

    return $objCompra;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return Compra
   */
  private function cargarObjetoConClave($datos) {
    $objCompra = null;

    if (isset($datos['idcompra'])) {
      $objCompra = new Compra();
      $objCompra->setear($datos['idcompra'], null, null);
    }
    return $objCompra;
  }


  /**
   * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
   * @param array $datos
   * @return boolean
   */

  private function seteadosCamposClaves($datos) {
    $resp = false;
    if (isset($datos['idcompra']))
      $resp = true;
    return $resp;
  }

  /**
   * 
   * @param array $datos
   */
  public function alta($datos) {
    $resp["exito"] = false;
    $datos['idcompra'] = null;
    $objCompra = $this->cargarObjeto($datos);

    if ($objCompra != null && $objCompra->insertar()) {
      $resp["exito"] = true;
      $resp["idcompra"] = $objCompra->getIdCompra();
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
      $objCompra = $this->cargarObjetoConClave($datos);
      if ($objCompra != null && $objCompra->eliminar()) {
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
      $objCompra = $this->cargarObjeto($datos);
      if ($objCompra != null && $objCompra->modificar()) {
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
      if (isset($datos['idcompra']))
        $where .= " and idcompra  = {$datos['idcompra']}";
      if (isset($datos['cofecha']))
        $where .= " and cofecha = '{$datos['cofecha']}'";
      if (isset($datos['idusuario']))
        $where .= " and idusuario = {$datos['idusuario']}";
    }
    $obj = new Compra();
    return $obj->listar($where);
  }
  public function getUltimaCompra($idUsuario) {
    $where = " idusuario=" . $idUsuario . " ORDER BY idcompra DESC LIMIT 1";
    $obj = new Compra;
    $res = $obj->listar($where);
    if (count($res) > 0) {
      $res = $res[0];
    }
    return $res;
  }

  public function getColItems($idCompra) {
    $colItem = new Compra();
    $colItem->setIdCompra($idCompra);
    return ($colItem->getColCompraItems());
  }
}
