<?php

/**
 * tab_cuerpos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_cuerpos extends db {

    var $cue_id;
    var $cue_orden;
    var $cue_codigo;
    var $cue_descripcion;
    var $cue_fecha_crea;
    var $cue_usuario_crea;
    var $cue_fecha_mod;
    var $cue_usuario_mod;
    var $cue_estado;

    function __construct() {
        parent::__construct();
    }

    function getCue_id() {
        return $this->cue_id;
    }

    function setCue_id($cue_id) {
        $this->cue_id = $cue_id;
    }

    function getCue_orden() {
        return $this->cue_orden;
    }

    function setCue_orden($cue_orden) {
        $this->cue_orden = $cue_orden;
    }

    function getCue_codigo() {
        return $this->cue_codigo;
    }

    function setCue_codigo($cue_codigo) {
        $this->cue_codigo = $cue_codigo;
    }

    function getCue_descripcion() {
        return $this->cue_descripcion;
    }

    function setCue_descripcion($cue_descripcion) {
        $this->cue_descripcion = $cue_descripcion;
    }

    function getCue_fecha_crea() {
        return $this->cue_fecha_crea;
    }

    function setCue_fecha_crea($cue_fecha_crea) {
        $this->cue_fecha_crea = $cue_fecha_crea;
    }

    function getCue_usuario_crea() {
        return $this->cue_usuario_crea;
    }

    function setCue_usuario_crea($cue_usuario_crea) {
        $this->cue_usuario_crea = $cue_usuario_crea;
    }

    function getCue_fecha_mod() {
        return $this->cue_fecha_mod;
    }

    function setCue_fecha_mod($cue_fecha_mod) {
        $this->cue_fecha_mod = $cue_fecha_mod;
    }

    function getCue_usuario_mod() {
        return $this->cue_usuario_mod;
    }

    function setCue_usuario_mod($cue_usuario_mod) {
        $this->cue_usuario_mod = $cue_usuario_mod;
    }

    function getCue_estado() {
        return $this->cue_estado;
    }

    function setCue_estado($cue_estado) {
        $this->cue_estado = $cue_estado;
    }

}

?>