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
class Par_frecuencia extends db {

    var $fre_id;
    var $fre_descripcion;
    var $fre_codigo;
    var $fre_usu_reg;
    var $fre_usu_mod;
    var $fre_fecha_reg;
    var $fre_fecha_mod;
    var $fre_estado;

    function __construct() {
        parent::__construct();
    }

    function getFre_id() {
        return $this->fre_id;
    }

    function setFre_id($fre_id) {
        $this->fre_id = $fre_id;
    }

    function getFre_descripcion() {
        return $this->fre_descripcion;
    }

    function setFre_descripcion($fre_descripcion) {
        $this->fre_descripcion = $fre_descripcion;
    }

    function getFre_codigo() {
        return $this->fre_codigo;
    }

    function setFre_codigo($fre_codigo) {
        $this->fre_codigo = $fre_codigo;
    }

    function getFre_usu_reg() {
        return $this->fre_usu_reg;
    }

    function setFre_usu_reg($fre_usu_reg) {
        $this->fre_usu_reg = $fre_usu_reg;
    }

    function getFre_usu_mod() {
        return $this->fre_usu_mod;
    }

    function setFre_usu_mod($fre_usu_mod) {
        $this->fre_usu_mod = $fre_usu_mod;
    }

    function getFre_fecha_reg() {
        return $this->fre_fecha_reg;
    }

    function setFre_fecha_reg($fre_fecha_reg) {
        $this->fre_fecha_reg = $fre_fecha_reg;
    }

    function getFre_fecha_mod() {
        return $this->fre_fecha_mod;
    }

    function setFre_fecha_mod($fre_fecha_mod) {
        $this->fre_fecha_mod = $fre_fecha_mod;
    }

    function getFre_estado() {
        return $this->fre_estado;
    }

    function setFre_estado($fre_estado) {
        $this->fre_estado = $fre_estado;
    }

}

?>
