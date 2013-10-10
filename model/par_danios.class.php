<?php

/**
 * tab_dansgos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Par_danios extends db {

    var $dan_id;
    var $dan_descripcion;
    var $dan_codigo;
    var $dan_usu_reg;
    var $dan_usu_mod;
    var $dan_fecha_reg;
    var $dan_fecha_mod;
    var $dan_estado;

    function __construct() {
        parent::__construct();
    }

    function getDan_id() {
        return $this->dan_id;
    }

    function setDan_id($dan_id) {
        $this->dan_id = $dan_id;
    }

    function getDan_descripcion() {
        return $this->dan_descripcion;
    }

    function setDan_descripcion($dan_descripcion) {
        $this->dan_descripcion = $dan_descripcion;
    }

    function getDan_codigo() {
        return $this->dan_codigo;
    }

    function setDan_codigo($dan_codigo) {
        $this->dan_codigo = $dan_codigo;
    }

    function getDan_usu_reg() {
        return $this->dan_usu_reg;
    }

    function setDan_usu_reg($dan_usu_reg) {
        $this->dan_usu_reg = $dan_usu_reg;
    }

    function getDan_usu_mod() {
        return $this->dan_usu_mod;
    }

    function setDan_usu_mod($dan_usu_mod) {
        $this->dan_usu_mod = $dan_usu_mod;
    }

    function getDan_fecha_reg() {
        return $this->dan_fecha_reg;
    }

    function setDan_fecha_reg($dan_fecha_reg) {
        $this->dan_fecha_reg = $dan_fecha_reg;
    }

    function getDan_fecha_mod() {
        return $this->dan_fecha_mod;
    }

    function setDan_fecha_mod($dan_fecha_mod) {
        $this->dan_fecha_mod = $dan_fecha_mod;
    }

    function getDan_estado() {
        return $this->dan_estado;
    }

    function setDan_estado($dan_estado) {
        $this->dan_estado = $dan_estado;
    }

}

?>
