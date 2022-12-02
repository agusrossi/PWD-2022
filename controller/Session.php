<?php
class Session {
    /**
     * Constructor
     */
    public function __construct() {
        if (!session_start()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados.
     */
    public function iniciar($nombreUsuario, $psw) {
        $resp = false;
        $obj = new AbmUsuario();
        $param['usnombre'] = $nombreUsuario;
        $param['uspass'] = $psw;
        $param['usdeshabilitado'] = 'null';

        $resultado = $obj->buscar($param);

        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            $_SESSION['idusuario'] = $usuario->getidusuario();
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }

    /**
     * Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar() {
        $resp = false;

        if ($this->activa() && isset($_SESSION['idusuario']))
            $resp = true;
        return $resp;
    }

    function logear($data) {
        $res = false;

        if (isset($data['usnombre']) && isset($data['uspass'])) {

            $res = $this->iniciar($data['usnombre'], md5($data['uspass']));

            if (!$this->validar()) {
                $res = false;
            }
        }

        return $res;
    }

    static public function activa() {
        return (isset($_SESSION['idusuario'])) ? true : false;
    }

    /**
     * Devuelve el usuario logeado.
     */
    public function getObjUsuario() {
        $usuario = null;
        if ($this->validar()) {
            $obj = new AbmUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $usuario = $resultado[0];
            }
        }
        return $usuario;
    }

    public function getRolActual() {
        $rolActual = null;
        if (isset($_SESSION['rol'])) {
            $rolActual = $_SESSION['rol'];
        }
        return $rolActual;
    }
    // modificar debe verificar q la pag corresconda con el rol


    public function tienePermiso() {
        $permiso = false;
        $objUs = new AbmUsuarioRol();

        if ($this->activa()) {

            $param = ["idusuario" => $this->getObjUsuario()->getIdUsuario(), "idrol" => $this->getRolActual()];
            $res = $objUs->buscar($param);

            if ($res != null && $this->getObjUsuario()->getUsDeshabilitado() != null) {
                $permiso = true;
            }
        }
        return $permiso;
    }

    function controlAcceso($data) {

        $resp = false;

        if (isset($data['idmenu'])) {
            $abmMenuRol = new AbmMenuRol;
            $col = $abmMenuRol->buscar(['idmenu' => $data['idmenu'], 'idrol' => $_SESSION['rol']]);

            if (count($col) != 0) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Devuelve el rol del usuario logeado.
     */
    public function getRol() {
        $list_rol = null;
        if ($this->validar()) {
            $obj = new AbmUsuarioRol();
            $param['idusuario'] = $_SESSION['idusuario'];
            $param['idrol'] = $_SESSION['idrol'];

            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $list_rol = $resultado;
            }
        }
        return $list_rol;
    }

    public function getColRol() {
        $list = null;
        if ($this->validar()) {
            $obj = new AbmUsuarioRol();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $list = $resultado;
            }
        }
        $res = $this->filtrarRoles($list);
        return $res;
    }
    private function filtrarRoles($list) {
        foreach ($list as $rol) {
            $res[] = $rol->getobjrol();
        }
        return $res;
    }
    /**
     *Cierra la sesión actual.
     */
    public function cerrar() {
        $resp = true;
        session_destroy();
        // $_SESSION['idusuario']=null;
        return $resp;
    }
}
