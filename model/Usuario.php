<?php

class Usuario extends BaseDatos {
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;

    private $mensajeoperacion;


    public function __construct() {
        parent::__construct();
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
        $this->mensajeoperacion = "";
    }
    public function setear($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado) {
        $this->setidusuario($idusuario);
        $this->setusnombre($usnombre);
        $this->setuspass($uspass);
        $this->setusmail($usmail);

        if ($usdeshabilitado = '0000-00-00 00:00:00')
            $usdeshabilitado = "null";

        $this->setusdeshabilitado($usdeshabilitado);
    }

    public function getIdUsuario() {
        return $this->idusuario;
    }
    public function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    public function getUsNombre() {
        return $this->usnombre;
    }
    public function setUsNombre($usnombre) {
        $this->usnombre = $usnombre;
    }
    public function getUsPass() {
        return $this->uspass;
    }
    public function setUsPass($uspass) {
        $this->uspass = $uspass;
    }
    public function getUsMail() {
        return $this->usmail;
    }
    public function setUsMail($usmail) {
        $this->usmail = $usmail;
    }
    public function getUsDeshabilitado() {
        return $this->usdeshabilitado;
    }
    public function setUsDeshabilitado($usdeshabilitado) {
        $this->usdeshabilitado = $usdeshabilitado;
    }

    public function getmensajeoperacion() {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor) {
        $this->mensajeoperacion = $valor;
    }

    public function cargar() {
        $resp = false;
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getidusuario();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                }
            }
        } else {
            $this->setmensajeoperacion( $this->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
      
        if ($this->getUsDeshabilitado() == null || $this->getUsDeshabilitado() == "null") {
            $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('{$this->getUsNombre()}','{$this->getUsPass()}', '{$this->getUsMail()}', NULL)";
        } else {
            $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('{$this->getUsNombre()}','{$this->getUsPass()}','{$this->getUsMail()}','{$this->getUsDeshabilitado()}')";
        }
       
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $this->setidusuario($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion($this->getError());
            }
        } else {
            $this->setmensajeoperacion($this->getError());
        }
        return $resp;
    }


    public function modificar() {
        $resp = false;
        $sql = "UPDATE usuario SET usnombre='" . $this->getusnombre() . "' ,uspass='" . $this->getuspass() . "',usmail='" . $this->getusmail() . "' ,usdeshabilitado='" . $this->getusdeshabilitado() . "'  " .
            " WHERE idusuario=" . $this->getidusuario();
        if ($this->Iniciar()) {
            echo $sql;
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($this->getError());
            }
        } else {
            $this->setmensajeoperacion($this->getError());
        }
        return $resp;
    }
    public function eliminar() {
        $resp = false;
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getidusuario();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion($this->getError());
            }
        } else {
            $this->setmensajeoperacion($this->getError());
        }
        return $resp;
    }


    public  function listar($parametro = "") {
        $arreglo = array();

        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql .= " WHERE {$parametro}";
        }

        $res = $this->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $this->Registro()) {
                    $obj = new Usuario();

                    $obj->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);

                    array_push($arreglo, $obj);
                }
            }
        }
        return $arreglo;
    }
}
