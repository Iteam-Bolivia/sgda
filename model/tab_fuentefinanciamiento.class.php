<?php

/**
 * tab_fuentefinanciamiento.class.php Class
 *
 * @package
 * @author Lic. Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class Tab_fuentefinanciamiento extends db {

    var $ff_id;
    var $ff_codigo;
    var $ff_descripcion;
    var $ff_fecha_crea;
    var $ff_usuario_crea;
    var $ff_fecha_mod;
    var $ff_usuario_mod;
    var $ff_estado;

    function __construct() {
        parent::__construct();
    }

    function getFF_id() {
        return $this->ff_id;
    }

    function setFF_id($ff_id) {
        $this->ff_id = $ff_id;
    }

    function getFF_codigo() {
        return $this->ff_codigo;
    }

    function setFF_codigo($ff_codigo) {
        $this->ff_codigo = $ff_codigo;
    }

    function getFF_descripcion() {
        return $this->ff_descripcion;
    }

    function setFF_descripcion($ff_descripcion) {
        $this->ff_descripcion = $ff_descripcion;
    }

    function getFF_fecha_crea() {
        return $this->ff_fecha_crea;
    }

    function setFF_fecha_crea($ff_fecha_crea) {
        $this->ff_fecha_crea = $ff_fecha_crea;
    }

    function getFF_usuario_crea() {
        return $this->ff_usuario_crea;
    }

    function setFF_usuario_crea($ff_usuario_crea) {
        $this->ff_usuario_crea = $ff_usuario_crea;
    }

    function getFF_fecha_mod() {
        return $this->ff_fecha_mod;
    }

    function setFF_fecha_mod($ff_fecha_mod) {
        $this->ff_fecha_mod = $ff_fecha_mod;
    }

    function getFF_usuario_mod() {
        return $this->ff_usuario_mod;
    }

    function setFF_usuario_mod($ff_usuario_mod) {
        $this->ff_usuario_mod = $ff_usuario_mod;
    }

    function getFF_estado() {
        return $this->ff_estado;
    }

    function setFF_estado($ff_estado) {
        $this->ff_estado = $ff_estado;
    }

}

?>