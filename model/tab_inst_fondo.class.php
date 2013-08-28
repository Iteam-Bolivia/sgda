<?php

/**
 * Tab_inst_fondo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_inst_fondo extends db {

    var $inl_id;
    var $ins_id;
    var $fon_id;
    var $inl_fecha_crea;
    var $inl_usu_crea;
    var $inl_fecha_mod;
    var $inl_usu_mod;
    var $inl_estado;

    function __construct() {
        parent::__construct();
    }

    function getInl_id() {
        return $this->inl_id;
    }

    function setInl_id($inl_id) {
        $this->inl_id = $inl_id;
    }

    function getIns_id() {
        return $this->ins_id;
    }

    function setIns_id($ins_id) {
        $this->ins_id = $ins_id;
    }

    function getFon_id() {
        return $this->fon_id;
    }

    function setFon_id($fon_id) {
        $this->fon_id = $fon_id;
    }

    function getInl_fecha_crea() {
        return $this->inl_fecha_crea;
    }

    function setInl_fecha_crea($inl_fecha_crea) {
        $this->inl_fecha_crea = $inl_fecha_crea;
    }

    function getInl_usu_crea() {
        return $this->inl_usu_crea;
    }

    function setInl_usu_crea($inl_usu_crea) {
        $this->inl_usu_crea = $inl_usu_crea;
    }

    function getInl_fecha_mod() {
        return $this->inl_fecha_mod;
    }

    function setInl_fecha_mod($inl_fecha_mod) {
        $this->inl_fecha_mod = $inl_fecha_mod;
    }

    function getInl_usu_mod() {
        return $this->inl_usu_mod;
    }

    function setInl_usu_mod($inl_usu_mod) {
        $this->inl_usu_mod = $inl_usu_mod;
    }

    function getInl_estado() {
        return $this->inl_estado;
    }

    function setInl_estado($inl_estado) {
        $this->inl_estado = $inl_estado;
    }

}

?>