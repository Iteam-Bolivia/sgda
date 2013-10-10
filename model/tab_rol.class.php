<?php

/**
 * tab_rol.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_rol extends db {

    var $rol_id;
    var $rol_titulo;
    var $rol_descripcion;
    var $rol_cod;
    var $rol_fecha_crea;
    var $rol_fecha_mod;
    var $rol_usuario_crea;
    var $rol_usuario_mod;
    var $rol_estado;

    function __construct() {
        parent::__construct();
    }

    function getRol_id() {
        return $this->rol_id;
    }

    function setRol_id($rol_id) {
        $this->rol_id = $rol_id;
    }

    function getRol_titulo() {
        return $this->rol_titulo;
    }

    function setRol_titulo($rol_titulo) {
        $this->rol_titulo = $rol_titulo;
    }

    function getRol_descripcion() {
        return $this->rol_descripcion;
    }

    function setRol_descripcion($rol_descripcion) {
        $this->rol_descripcion = $rol_descripcion;
    }

    function getRol_cod() {
        return $this->rol_cod;
    }

    function setRol_cod($rol_cod) {
        $this->rol_cod = $rol_cod;
    }

    function getRol_fecha_crea() {
        return $this->rol_fecha_crea;
    }

    function setRol_fecha_crea($rol_fecha_crea) {
        $this->rol_fecha_crea = $rol_fecha_crea;
    }

    function getRol_fecha_mod() {
        return $this->rol_fecha_mod;
    }

    function setRol_fecha_mod($rol_fecha_mod) {
        $this->rol_fecha_mod = $rol_fecha_mod;
    }

    function getRol_usuario_crea() {
        return $this->rol_usuario_crea;
    }

    function setRol_usuario_crea($rol_usuario_crea) {
        $this->rol_usuario_crea = $rol_usuario_crea;
    }

    function getRol_usuario_mod() {
        return $this->rol_usuario_mod;
    }

    function setRol_usuario_mod($rol_usuario_mod) {
        $this->rol_usuario_mod = $rol_usuario_mod;
    }

    function getRol_estado() {
        return $this->rol_estado;
    }

    function setRol_estado($rol_estado) {
        $this->rol_estado = $rol_estado;
    }

}

?>