<?php

/**
 * dpermisos_sistemas.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class dpermisos_sistemas extends db {

    var $sistema;
    var $usu_login;
    var $entidad;
    var $nombre_completo;
    var $estado;

    function __construct() {
        parent::__construct();
    }

    function getSistema() {
        return $this->sistema;
    }

    function setSistema($sistema) {
        $this->sistema = $sistema;
    }

    function getUsu_login() {
        return $this->usu_login;
    }

    function setUsu_login($usu_login) {
        $this->usu_login = $usu_login;
    }

    function getEntidad() {
        return $this->entidad;
    }

    function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    function getNombre_completo() {
        return $this->nombre_completo;
    }

    function setNombre_completo($nombre_completo) {
        $this->nombre_completo = $nombre_completo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
?>
