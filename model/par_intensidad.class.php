<?php

/**
 * tab_fresgos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Par_intensidad extends db {

    var $int_id;
    var $int_descripcion;
    var $int_codigo;
    var $int_usu_reg;
    var $int_usu_mod;
    var $int_fecha_reg;
    var $int_fecha_mod;
    var $int_estado;

    function __construct() {
        parent::__construct();
    }

    function getInt_id() {
        return $this->int_id;
    }

    function setInt_id($int_id) {
        $this->int_id = $int_id;
    }

    function getInt_descripcion() {
        return $this->int_descripcion;
    }

    function setInt_descripcion($int_descripcion) {
        $this->int_descripcion = $int_descripcion;
    }

    function getInt_codigo() {
        return $this->int_codigo;
    }

    function setInt_codigo($int_codigo) {
        $this->int_codigo = $int_codigo;
    }

    function getInt_usu_reg() {
        return $this->int_usu_reg;
    }

    function setInt_usu_reg($int_usu_reg) {
        $this->int_usu_reg = $int_usu_reg;
    }

    function getInt_usu_mod() {
        return $this->int_usu_mod;
    }

    function setInt_usu_mod($int_usu_mod) {
        $this->int_usu_mod = $int_usu_mod;
    }

    function getInt_fecha_reg() {
        return $this->int_fecha_reg;
    }

    function setInt_fecha_reg($int_fecha_reg) {
        $this->int_fecha_reg = $int_fecha_reg;
    }

    function getInt_fecha_mod() {
        return $this->int_fecha_mod;
    }

    function setInt_fecha_mod($int_fecha_mod) {
        $this->int_fecha_mod = $int_fecha_mod;
    }

    function getInt_estado() {
        return $this->int_estado;
    }

    function setInt_estado($int_estado) {
        $this->int_estado = $int_estado;
    }

}

?>
