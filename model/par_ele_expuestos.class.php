<?php

/**
 * tab_elesgos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Par_ele_expuestos extends db {

    var $ele_id;
    var $ele_descripcion;
    var $ele_codigo;
    var $ele_usu_reg;
    var $ele_usu_mod;
    var $ele_fecha_reg;
    var $ele_fecha_mod;
    var $ele_estado;

    function __construct() {
        parent::__construct();
    }

    function getEle_id() {
        return $this->ele_id;
    }

    function setEle_id($ele_id) {
        $this->ele_id = $ele_id;
    }

    function getEle_descripcion() {
        return $this->ele_descripcion;
    }

    function setEle_descripcion($ele_descripcion) {
        $this->ele_descripcion = $ele_descripcion;
    }

    function getEle_codigo() {
        return $this->ele_codigo;
    }

    function setEle_codigo($ele_codigo) {
        $this->ele_codigo = $ele_codigo;
    }

    function getEle_usu_reg() {
        return $this->ele_usu_reg;
    }

    function setEle_usu_reg($ele_usu_reg) {
        $this->ele_usu_reg = $ele_usu_reg;
    }

    function getEle_usu_mod() {
        return $this->ele_usu_mod;
    }

    function setEle_usu_mod($ele_usu_mod) {
        $this->ele_usu_mod = $ele_usu_mod;
    }

    function getEle_fecha_reg() {
        return $this->ele_fecha_reg;
    }

    function setEle_fecha_reg($ele_fecha_reg) {
        $this->ele_fecha_reg = $ele_fecha_reg;
    }

    function getEle_fecha_mod() {
        return $this->ele_fecha_mod;
    }

    function setEle_fecha_mod($ele_fecha_mod) {
        $this->ele_fecha_mod = $ele_fecha_mod;
    }

    function getEle_estado() {
        return $this->ele_estado;
    }

    function setEle_estado($ele_estado) {
        $this->ele_estado = $ele_estado;
    }

}

?>
