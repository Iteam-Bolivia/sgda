<?php

/**
 * tab_modalidad.class.php Class
 *
 * @package
 * @author Lic. Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class Tab_modalidad extends db {

    var $mod_id;
    var $mod_codigo;
    var $mod_descripcion;
    var $mod_fecha_crea;
    var $mod_usuario_crea;
    var $mod_fecha_mod;
    var $mod_usuario_mod;
    var $mod_estado;

    function __construct() {
        parent::__construct();
    }

    function getMod_id() {
        return $this->mod_id;
    }

    function setMod_id($mod_id) {
        $this->mod_id = $mod_id;
    }

    function getMod_codigo() {
        return $this->mod_codigo;
    }

    function setMod_codigo($mod_codigo) {
        $this->mod_codigo = $mod_codigo;
    }

    function getMod_descripcion() {
        return $this->mod_descripcion;
    }

    function setMod_descripcion($mod_descripcion) {
        $this->mod_descripcion = $mod_descripcion;
    }

    function getMod_fecha_crea() {
        return $this->mod_fecha_crea;
    }

    function setMod_fecha_crea($mod_fecha_crea) {
        $this->mod_fecha_crea = $mod_fecha_crea;
    }

    function getMod_usuario_crea() {
        return $this->mod_usuario_crea;
    }

    function setMod_usuario_crea($mod_usuario_crea) {
        $this->mod_usuario_crea = $mod_usuario_crea;
    }

    function getMod_fecha_mod() {
        return $this->mod_fecha_mod;
    }

    function setMod_fecha($mod_fecha_mod) {
        $this->mod_fecha_mod = $mod_fecha_mod;
    }

    function getMod_usuario_mod() {
        return $this->mod_usuario_mod;
    }

    function setMod_usuario_mod($mod_usuario_mod) {
        $this->mod_usuario_mod = $mod_usuario_mod;
    }

    function getMod_estado() {
        return $this->mod_estado;
    }

    function setMod_estado($mod_estado) {
        $this->mod_estado = $mod_estado;
    }

}

?>