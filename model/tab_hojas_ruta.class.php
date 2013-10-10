<?php

/**
 * tab_hoja_ruta.class.php Class
 * SIACO
 * 
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

// Hereda Clase de conexion Mysql
class Tab_hojas_ruta extends db2 {

    var $nur;
    var $codigo;
    var $nro;
    var $estado;
    var $fecha;
    var $usuario;
    var $proceso;

    function __construct() {
        parent::__construct();
    }

    function getNur() {
        return $this->nur;
    }

    function setNur($nur) {
        $this->nur = $nur;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getNro() {
        return $this->nro;
    }

    function setNro($nro) {
        $this->nro = $nro;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
          
    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function getProceso() {
        return $this->proceso;
    }

    function setProceso($proceso) {
        $this->proceso = $proceso;
    }



}

?>