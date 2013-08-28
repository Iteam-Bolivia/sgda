<?php

/**
 * tab_tramite.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_tramite extends db {

    var $tra_id;
    var $tra_orden;
    var $tra_codigo;
    var $tra_descripcion;
    var $tra_fecha_crea;
    var $tra_usuario_crea;
    var $tra_fecha_mod;
    var $tra_usuario_mod;
    var $tra_estado;

    function __construct() {
        parent::__construct();
    }

    function getTra_id() {
        return $this->tra_id;
    }

    function setTra_id($tra_id) {
        $this->tra_id = $tra_id;
    }

    function getTra_orden() {
        return $this->tra_orden;
    }

    function setTra_orden($tra_orden) {
        $this->tra_orden = $tra_orden;
    }

    function getTra_codigo() {
        return $this->tra_codigo;
    }

    function setTra_codigo($tra_codigo) {
        $this->tra_codigo = $tra_codigo;
    }

    function getTra_descripcion() {
        return $this->tra_descripcion;
    }

    function setTra_descripcion($tra_descripcion) {
        $this->tra_descripcion = $tra_descripcion;
    }

    function getTra_fecha_crea() {
        return $this->tra_fecha_crea;
    }

    function setTra_fecha_crea($tra_fecha_crea) {
        $this->tra_fecha_crea = $tra_fecha_crea;
    }

    function getTra_usuario_crea() {
        return $this->tra_usuario_crea;
    }

    function setTra_usuario_crea($tra_usuario_crea) {
        $this->tra_usuario_crea = $tra_usuario_crea;
    }

    function getTra_fecha_mod() {
        return $this->tra_fecha_mod;
    }

    function setTra_fecha_mod($tra_fecha_mod) {
        $this->tra_fecha_mod = $tra_fecha_mod;
    }

    function getTra_usuario_mod() {
        return $this->tra_usuario_mod;
    }

    function setTra_usuario_mod($tra_usuario_mod) {
        $this->tra_usuario_mod = $tra_usuario_mod;
    }

    function getTra_estado() {
        return $this->tra_estado;
    }

    function setTra_estado($tra_estado) {
        $this->tra_estado = $tra_estado;
    }

}

?>